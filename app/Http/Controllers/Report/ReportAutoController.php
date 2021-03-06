<?php

namespace Sibas\Http\Controllers\Report;

use Illuminate\Contracts\Auth\Guard;
use Sibas\Http\Controllers\Excel\ExportXlsController;
use DB;
use Illuminate\Http\Request;
use Sibas\Http\Requests;
use Sibas\Http\Controllers\ReportTrait;
use Sibas\Http\Controllers\Controller;
use Sibas\Entities\Au\Detail;
use Sibas\Entities\RetailerProductState;

class ReportAutoController extends Controller {
use ReportTrait;
    var $object = [];
    public $value = '';
    public $valueOr = '';

    public function __construct(Guard $auth) {
        $this->data    = $this->data($auth->user());
        $data = $this->selectIdNameTable($this->data);
        $this->users = $data['users'];
        $this->agencies = $data['agencies'];
        $this->cities = $data['cities'];
        $this->extencion = DB::table('ad_cities')->lists('name', 'abbreviation');
        $this->observation = DB::table('op_de_observations')->orderBy('id', 'DESC')->get();
    }
    
    public function selectIdNameTable(){
        $arr = [];
        foreach ($this->data as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if($value2['name'] != 'Todos'){
                    switch ($key) {
                        case 'cities':
                            $val = DB::table('ad_cities')->where('ad_cities.name',$value2['name'])->first();
                            $arr[$key][$val->id]=$val->name;           
                            break;
                        case 'agencies':
                            $val = DB::table('ad_agencies')->where('ad_agencies.name',$value2['name'])->first();
                            $arr[$key][$val->id]=$val->name;
                            break;
                        case 'users':
                            $val = DB::table('ad_users')->where('ad_users.username',$value2['username'])->first();
                            $arr[$key][$val->id]=$val->username.' | '.$val->full_name;
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $arr;
    }
    /**
     * funcion determina tipo de reporte si es polizas emitidas o general
     * @param type $request
     */
    public function tipoReporte($request) {
        $flag = '';
        if ($request->method() == 'GET') {
            $url = explode('/', $request->path());
            $flag = $url[2];
        } else {
            $flag = $request->get('flag');
        }
        return $flag;
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    public function general(Request $request,$id_comp) {
        $flag = 1;
        $users = $this->users;
        $agencies = $this->agencies;
        $cities = $this->cities;
        $extencion = $this->extencion;
        
        
        $rp_state = RetailerProductState::where('ad_retailer_product_id', decode($id_comp))->get();
        $valueForm = $this->addValueForm($request, $rp_state);

        $array = $this->result($request, $flag, $rp_state);
        $result = $array['result'];

        # validacion exporta xls
        if ($request->get('xls_download'))
            $this->exportXls($result, 'General', 1);

        return view('report.general_auto', compact('result', 'users', 'agencies', 'cities', 'extencion', 'valueForm', 'flag', 'id_comp', 'rp_state'));
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    public function general_emitido(Request $request, $id_comp) {
        $flag = 2;
        $users = $this->users;
        $agencies = $this->agencies;
        $cities = $this->cities;
        $extencion = $this->extencion;

        $valueForm = $this->addValueForm($request);
        $rp_state = array();
        $array = $this->result($request, $flag);
        $result = $array['result'];

        # validacion exporta xls
        if ($request->get('xls_download'))
            $this->exportXls($result, 'General', 1);

        return view('report.general_auto', compact('result', 'users', 'agencies', 'cities', 'extencion', 'valueForm', 'flag','id_comp', 'rp_state'));
    }

    /**
     * fuincion retorna resultado de consulta y busqueda de formulario
     * @param type $request
     * @param type $flag
     * @return type
     */
    public function result($request, $flag, $rp_state = array()) {

        $opClients = DB::table('op_clients')
                ->join('op_de_details', 'op_clients.id', '=', 'op_de_details.op_client_id')
                ->select('op_de_details.op_de_header_id');
        if ($request->get('xls_download'))
            $keyGroup = 'op_au_details.id';
        else
            $keyGroup = 'op_au_headers.id';

        $query = DB::table('op_au_headers')
                ->join('ad_users', 'op_au_headers.ad_user_id', '=', 'ad_users.id')
                ->join('ad_agencies', 'ad_users.ad_agency_id', '=', 'ad_agencies.id')
                ->join('ad_cities', 'ad_users.ad_city_id', '=', 'ad_cities.id')
                ->join('op_au_details', 'op_au_headers.id', '=', 'op_au_details.op_au_header_id')
                ->join('ad_vehicle_types', 'op_au_details.ad_vehicle_type_id', '=', 'ad_vehicle_types.id')
                ->join('ad_vehicle_makes', 'op_au_details.ad_vehicle_make_id', '=', 'ad_vehicle_makes.id')
                ->join('ad_vehicle_models', 'op_au_details.ad_vehicle_model_id', '=', 'ad_vehicle_models.id')
                ->leftJoin('op_au_cancellations', 'op_au_cancellations.op_au_header_id', '=', 'op_au_headers.id')
                ->leftJoin('ad_users as user_c', 'user_c.id', '=', 'op_au_cancellations.ad_user_id')
                
                ->leftJoin('op_au_facultatives', 'op_au_details.id', '=', 'op_au_facultatives.op_au_detail_id')
                ->leftJoin('op_au_observations', 'op_au_facultatives.id', '=', 'op_au_observations.op_au_facultative_id')
                ->join('op_clients', 'op_au_headers.op_client_id', '=', 'op_clients.id')
                ->orderBy('op_au_headers.issue_number','desc')
                ->groupBy($keyGroup)
                
                ->select(
                        'op_au_headers.id', 
                        DB::raw("CONCAT(op_au_headers.prefix, ' - ',op_au_headers.issue_number ) as nro_cotizacion"),
                        DB::raw("CONCAT(op_clients.first_name,' ',op_clients.last_name,' ',op_clients.mother_last_name) as cliente"), 
                        DB::raw("CONCAT(op_clients.dni,' ',op_clients.complement,' ',op_clients.extension) as ci"), 
                        DB::raw("IF(op_clients.gender='M','Masculino','Femenino') as genero"),
                        DB::raw('CONCAT(op_au_headers.term," ",IF(op_au_headers.type_term="Y","Años",IF(op_au_headers.type_term="M","Meses",IF(op_au_headers.type_term="D","Dias","null")))) as plazo_de_credito'), 
                        
                        'op_au_headers.payment_method as forma_de_pago', 
                        'op_au_headers.operation_number as numero_credito', 
                        'ad_vehicle_types.vehicle as tipo_vehiculo', 
                        'ad_vehicle_models.model as modelo', 
                        'op_au_details.year as anio', 
                        'op_au_details.license_plate as placa', 
                        DB::raw('IF(op_au_details.use="PR","Privado",IF(op_au_details.use="PU","Publico","Ninguno")) as uso'),
                        'op_au_details.traction as traccion', 
                        DB::raw('IF(op_au_details.mileage="1","SI","NO") as cero_km'),
                        'op_au_details.insured_value as valor_asegurado',
                        'op_au_headers.currency as moneda',
                        
                        'ad_users.full_name as usuario', 
                        'ad_cities.name as sucursal_registro', 
                        'ad_agencies.name as agencia',
                        'op_au_headers.created_at as fecha_de_ingreso',
                        'op_au_headers.canceled as anulado',
                        'user_c.full_name as anulado_por',
                        'op_au_cancellations.created_at as fecha_anulacion',
                        
                        # estado compañia
                        DB::raw("if(op_au_headers.issued=TRUE and op_au_headers.facultative=FALSE,'Aprobado Freecover',
                                if(op_au_headers.facultative=true and op_au_facultatives.state='PR' and op_au_facultatives.approved=TRUE,'Aprobado',
                                if(op_au_headers.facultative=true and op_au_facultatives.state='PR' and op_au_facultatives.approved=FALSE,'Rechazado',
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE' and op_au_observations.id is null,'Pendiente',
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE' and 
                                (SELECT odo.response
                                    FROM op_au_observations AS odo
                                    WHERE odo.op_au_facultative_id = op_au_facultatives.id 
                                    ORDER BY odo.id DESC limit 0,1) = true,'Subsanado Pendiente',
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE' and op_au_observations.id is not null,'Observado',
                                '')))))) as estado_compania"),
                        
                        # observaciones
                        DB::raw("if(op_au_facultatives.state='PR',op_au_facultatives.observation,
                                if(op_au_facultatives.state='PE',
                                 (
                                 SELECT t9.observation
                                    FROM op_au_observations t9
                                    WHERE t9.op_au_facultative_id = op_au_facultatives.id
                                    ORDER BY t9.id DESC
                                    LIMIT 0, 1),
                                '')) as observation_facultative"),
                        
                        # motivo estado compañia
                        DB::raw("if(op_au_headers.facultative=true and op_au_facultatives.state='PR' and op_au_facultatives.approved=TRUE,'Aprobado',
                                if(op_au_headers.facultative=true and op_au_facultatives.state='PR' and op_au_facultatives.approved=false,'Rechazado',
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE' and op_au_observations.id is not null,
                                 (
                                 SELECT t6.state
                                    FROM op_au_observations t8
                                    INNER JOIN ad_states t6 ON (t6.id=t8.ad_state_id)
                                    WHERE t8.op_au_facultative_id= op_au_facultatives.id
                                    ORDER BY t8.id DESC
                                    LIMIT 0, 1),
                                ''))) as motivo_estado_compania"),
                        # porcentaje extra prima
                        DB::raw("if(op_au_headers.facultative=true and op_au_facultatives.state='PR' and op_au_facultatives.approved=TRUE and op_au_facultatives.surcharge=true,op_au_facultatives.percentage,'') as porcentaje_extraprima"),
                        # estado banco
                        DB::raw("if(op_au_headers.issued=true ,'Emitido', if(op_au_headers.issued=false ,'No Emitido','')) as estado_banco"),
                        # fecha respuesta final compañia
                        DB::raw("if(op_au_headers.issued=TRUE and op_au_headers.facultative=true and op_au_facultatives.state='PR' ,DATE_FORMAT(op_au_facultatives.updated_at,'%d/%m/%Y %h:%i'),
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE'  and op_au_observations.id is not null ,DATE_FORMAT(op_au_observations.created_at,'%d/%m/%Y %h:%i'),'')) as fecha_respuesta_final_compania"),
                        # dias en proceso
                        DB::raw("if(op_au_headers.issued=TRUE and op_au_headers.facultative=true and op_au_facultatives.state='PR' ,DATEDIFF(op_au_facultatives.updated_at,op_au_headers.created_at),
                                if(op_au_headers.issued=TRUE and op_au_headers.facultative=false,DATEDIFF(op_au_headers.date_issue,op_au_headers.created_at),
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE' and op_au_observations.id is null ,DATEDIFF(CURDATE(),op_au_headers.created_at),
                                if(op_au_headers.issued=false and op_au_headers.facultative=true and op_au_facultatives.state='PE' and op_au_observations.id is not null ,DATEDIFF(op_au_observations.created_at,op_au_headers.created_at),'')
                                ))) as dias_en_proceso"),
                        # dias duracion total del caso
                        DB::raw("if(op_au_headers.issued=TRUE ,CONCAT(DATEDIFF(op_au_headers.date_issue,op_au_headers.created_at),' dias'),
                                if(op_au_headers.issued=false ,CONCAT(DATEDIFF(CURDATE(),op_au_headers.created_at),' dias'),'')) as duracion_total_del_caso")
                )
                ->where('op_au_headers.type', 'I');

        if ($flag == 2){
            # reporte polizas emitidas
            $query->where('op_au_headers.issued', 1);
        }else{
            if ($request->get('anulados')) {
                switch ($request->get('anulados')) {
                    case 1:
                    case 2:
                        $query->where('op_au_headers.issued', 1);
                        break;
                    default:
                        break;
                }
            }
        }
        $details = array();
        $result = array();
        $flagClient = 0;

        if ($request->get('_token')) {
            
            $arr = $this->role('au', $request, $rp_state);

            foreach ($arr as $key => $value) {

                if ($key == 'and') {
                    
                    foreach ($value as $key2 => $value2) {
                                
                        $this->value = $value2;
                        $query->where(function($q) {
                            foreach ($this->value as $key3 => $value3) {
                                if (is_array($value3)) {
                                        $q->whereRaw($key3 . ' ' . $value3[0] . '"' . $value3[1] . '"');
                                } else {
                                    if($value3 === 'block')
                                        $q->whereRaw($key3);
                                    else
                                        $q->whereRaw($key3 . ' = "' . $value3 . '"');
                                }
                            }
                            $q->whereRaw('`op_au_headers`.`type`="I"');
                        });
                    }
                } elseif ($key == 'or') {
                    foreach ($value as $key2 => $value2) {
                            $this->valueOr = $value2;
                            $query->orWhere(function($q) {
                                foreach ($this->valueOr as $key3 => $value3) {
                                    if (is_array($value3)) {
                                        $q->whereRaw($key3 . ' ' . $value3[0] . '"' . $value3[1] . '"');
                                    } else {
                                        if($value3 === 'block')
                                            $q->whereRaw($key3);
                                        else
                                            $q->whereRaw($key3 . ' = "' . $value3 . '"');
                                    }
                                }
                                $q->whereRaw('`op_au_headers`.`type`="I"');
                            });
                    }
                }
            }

            # numero poliza
            if ($request->get('numero_poliza'))
                $query->where('op_au_headers.issue_number', 'LIKE', '%' . $request->get('numero_poliza') . '%');
            
            # usuario vendedor
            if ($request->get('usuario'))
                $query->where('op_au_headers.ad_user_id', $request->get('usuario'));

            # usuario vendedor agencia
            if ($request->get('agencia'))
                $query->where('ad_users.ad_agency_id', $request->get('agencia'));

            # usuario vendedor sucursal
            if ($request->get('sucursal'))
                $query->where('ad_users.ad_city_id', $request->get('sucursal'));

            # fecha de emision inicial
            if ($request->get('fecha_ini'))
                $query->where('op_au_headers.created_at', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->get('fecha_ini')))));

            # fecha de emision final
            if ($request->get('fecha_fin'))
                $query->where('op_au_headers.created_at', '<=', date('Y-m-d', strtotime('+1 days', strtotime(str_replace('/', '-', $request->get('fecha_fin'))))));

            # anulados
            if ($request->get('anulados')) {
                switch ($request->get('anulados')) {
                    case 1:
                        $query->where('op_au_headers.canceled', 1);
                        break;
                    case 2:
                        $query->where('op_au_headers.canceled', 0);
                        break;
                    default:
                        break;
                }
            }


            # extencion cliente
            if ($request->get('extension'))
                $query->where('op_clients.extension', $request->get('extension'));
            
            # ci cliente
            if ($request->get('ci'))
                $query->where('op_clients.dni', 'LIKE', '%' . $request->get('ci') . '%');
            
            # complemento
            if ($request->get('complement'))
                $query->where('op_clients.complement', $request->get('complement'));

            # nombre cliente
            if ($request->get('cliente'))
                $query->where('op_clients.first_name', 'LIKE', '%' . $request->get('cliente') . '%');


            if ($request->get('extension') || $request->get('ci') || $request->get('cliente'))
                $flagClient = 1;

            //edw-->$details = $opClients->get();

            $result = $query->get();
        }else {
            $result = $query->get();
        }

        $result = $this->observations($request, $result);

        # validacion exporta xls
        if ($request->get('xls_download')) {
            $resArr = [];
            $i = 0;
            foreach ($result as $key => $value) {
                $resArr[$i]['Nro. Emisión'] = $value->nro_cotizacion;
                $resArr[$i]['Cliente'] = $value->cliente;
                $resArr[$i]['C.I.'] = $value->ci;
                $resArr[$i]['Genero'] = $value->genero;
                $resArr[$i]['Plazo de Credito'] = $value->plazo_de_credito;
                $resArr[$i]['Forma de Pago'] = ($value->forma_de_pago == 'AN') ? 'Anualizado' : 'Prima Total';
                $resArr[$i]['Nro. Credito'] = $value->numero_credito;
                $resArr[$i]['Auto'] = $value->tipo_vehiculo;
                $resArr[$i]['Modelo'] = $value->modelo;
                $resArr[$i]['Año'] = $value->anio;
                $resArr[$i]['Placa'] = $value->placa;
                $resArr[$i]['0 Km.'] = $value->cero_km;
                $resArr[$i]['Valor Asegurado'] = $value->valor_asegurado . ' ' . $value->moneda;
                $resArr[$i]['Usuario'] = $value->usuario;
                $resArr[$i]['Sucursal Registro'] = $value->sucursal_registro;
                $resArr[$i]['Agencia'] = $value->agencia;
                $resArr[$i]['Fecha de Ingreso'] = $value->fecha_de_ingreso;
                $resArr[$i]['Anulado'] = ($value->anulado == 0) ? 'NO' : 'SI';
                $resArr[$i]['Anulado Por'] = $value->anulado_por;
                $resArr[$i]['Fecha Anualción'] = $value->fecha_anulacion;
                $resArr[$i]['Facultativo Observación'] = $value->observation_facultative;
                $resArr[$i]['Estado Compañia'] = $value->estado_compania;
                $resArr[$i]['Motivo Estado Compañia'] = $value->motivo_estado_compania;
                $resArr[$i]['Estado Banco'] = $value->estado_banco;
                $resArr[$i]['Porcentaje Extraprima'] = $value->porcentaje_extraprima;
                $resArr[$i]['Fecha Respuesta Final Compañia'] = $value->fecha_respuesta_final_compania;
                $resArr[$i]['Duración Total del Caso'] = $value->duracion_total_del_caso;
                $i++;
            }
            $this->exportXls($resArr, 'General', 1, 'A1:Z1');
        }


        # listado de autos registrados por cliente
        foreach ($result as $key => $value) {
            $result[$key]->auDetail = Detail::where('op_au_header_id', $value->id)->get();
        }

        $res = array('result' => $result, 'flag' => $flag);

        return $res;
    }
    
    /**
     * regla de consulta observacion para el filtro
     * @param type $request
     * @return array
     */
    public function observations($request, $array) {
        # registros observaciones
        $opDeObservations = DB::table('op_au_observations')->orderBy('id', 'desc')->get();
        $observation = [];
        foreach ($opDeObservations as $key => $value) {
            if (!isset($observation[$value->op_au_facultative_id])) {
                $observation[$value->op_au_facultative_id] = $value;
            }
        }

        # estados
        $adStates = DB::table('ad_states')->get();
        $states = [];
        foreach ($adStates as $key => $value) {
            $states[$value->id] = $value;
        }

        $consult = [];
        if ($request->get('pendiente'))
            $consult[] = 'no';

        if ($request->get('subsanado')) {
            $consult[] = 'si';
            $consult[] = 'cl';
        }

        if ($request->get('observado'))
            $consult[] = 'si';

        if (count($consult) > 0) {
            $ress = [];
            foreach ($array as $key => $value) {
                if (in_array('no', $consult) && !in_array('si', $consult)) {
                    # no debe existir en observaciones
                    if (!isset($observation['1453731639'])) {
                        $ress[$key] = $value;
                    }
                } elseif (in_array('no', $consult) && in_array('si', $consult)) {
                    #exista o no ingresan todos
                    $ress[$key] = $value;
                } elseif (in_array('si', $consult) && !in_array('no', $consult)) {

                    if (in_array('cl', $consult)) {
                        if (isset($observation['1453731639']) && $states[$observation['1453731639']->ad_state_id]->slug == 'cl') {
                            
                        }
                        $ress[$key] = $value;
                    } else {
                        #solo si existe
                        if (isset($observation['1453731639'])) {
                            
                        }
                        $ress[$key] = $value;
                    }
                }
            }

            return $ress;
        } else {
            return $array;
        }
    }

    /**
     * fucion retorna cotizaciones
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    public function cotizacion(Request $request,$id_comp) {
        $users = $this->users;
        $agencies = $this->agencies;
        $cities = $this->cities;
        $extencion = $this->extencion;
        if ($request->get('xls_download'))
            $keyGroup = 'op_au_details.id';
        else
            $keyGroup = 'op_au_headers.id';

        $valueForm = $this->addValueForm($request);
        $query = DB::table('op_au_headers')
                ->join('op_clients', 'op_au_headers.op_client_id', '=', 'op_clients.id')
                ->join('ad_users', 'op_au_headers.ad_user_id', '=', 'ad_users.id')
                ->join('ad_cities', 'ad_users.ad_city_id', '=', 'ad_cities.id')
                ->join('op_au_details', 'op_au_headers.id', '=', 'op_au_details.op_au_header_id')
                ->join('ad_vehicle_types', 'op_au_details.ad_vehicle_type_id', '=', 'ad_vehicle_types.id')
                ->join('ad_vehicle_makes', 'op_au_details.ad_vehicle_make_id', '=', 'ad_vehicle_makes.id')
                ->join('ad_vehicle_models', 'op_au_details.ad_vehicle_model_id', '=', 'ad_vehicle_models.id')
                ->leftJoin('ad_agencies', 'ad_users.ad_agency_id', '=', 'ad_agencies.id')
                ->orderBy('op_au_headers.quote_number','desc')
                ->groupBy($keyGroup)
                ->select(
                'op_au_headers.id', 'op_au_headers.quote_number as nro_cotizacion', 
                DB::raw("CONCAT(op_clients.first_name,' ',op_clients.last_name,' ',op_clients.mother_last_name) as cliente"), 
                        DB::raw("CONCAT(op_clients.dni,' ',op_clients.complement,' ',op_clients.extension) as ci"), 
                        'ad_cities.name as ciudad', 
                        DB::raw('IF(op_clients.gender="M","Masculino","Femenino") as genero'), 
                        DB::raw('CONCAT(op_au_headers.term," ",IF(op_au_headers.type_term="Y","Años",IF(op_au_headers.type_term="M","Meses",IF(op_au_headers.type_term="D","Dias","null")))) as plazo_de_credito'), 
                        DB::raw('IF(op_au_headers.payment_method="AN","Anualizado","Prima Total") as forma_de_pago'),
                        'op_au_headers.operation_number as numero_credito', 
                        'ad_users.full_name as usuario', 
                        'ad_cities.name as sucursal_registro', 
                        'ad_agencies.name as agencia',
                        'ad_vehicle_types.vehicle as tipo_vehiculo', 
                        'ad_vehicle_models.model as modelo', 
                        'op_au_details.year as anio', 
                        'op_au_details.license_plate as placa', 
                        DB::raw('IF(op_au_details.use="PR","Privado",IF(op_au_details.use="PU","Publico","Ninguno")) as uso'),
                        'op_au_details.traction as traccion', 
                        DB::raw('IF(op_au_details.mileage="1","SI","NO") as cero_km'),
                        'op_au_details.insured_value as valor_asegurado',
                        'op_au_headers.currency as moneda'
        )
        ->where('op_au_headers.issued', 0);


        $details = array();
        $result = array();
        $flagClient = 0;
        if ($request->get('_token')) {
            # usuario vendedor
            if ($request->get('usuario'))
                $query->where('op_au_headers.ad_user_id', $request->get('usuario'));

            # usuario vendedor nro_cotizacion
            if ($request->get('nro_cotizacion'))
                $query->where('op_au_headers.quote_number', 'LIKE', '%' . $request->get('nro_cotizacion') . '%');

            # usuario vendedor sucursal
            if ($request->get('sucursal'))
                $query->where('ad_users.ad_city_id', $request->get('sucursal'));

            # usuario vendedor agencia
            if ($request->get('agencia'))
                $query->where('ad_users.ad_agency_id', $request->get('agencia'));
            
            # fecha de emision inicial
            if ($request->get('fecha_ini'))
                $query->where('op_au_headers.created_at', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->get('fecha_ini')))));

            # fecha de emision final
            if ($request->get('fecha_fin'))
                $query->where('op_au_headers.created_at', '<=', date('Y-m-d', strtotime('+1 days', strtotime(str_replace('/', '-', $request->get('fecha_fin'))))));

            # extencion cliente
            if ($request->get('extension'))
                $query->where('op_clients.extension', $request->get('extension'));
            
            # ci cliente
            if ($request->get('ci'))
                $query->where('op_clients.dni', 'LIKE', '%' . $request->get('ci') . '%');
            
            # complemento cliente
            if ($request->get('complement'))
                $query->where('op_clients.complement', $request->get('complement'));

            # nombre cliente
            if ($request->get('cliente'))
                $query->where('op_clients.first_name', 'LIKE', '%' . $request->get('cliente') . '%');


            $result = $query->get();
        }else {
            $result = $query->get();
        }

        # validacion exporta xls
        if ($request->get('xls_download')){
            $resArr = [];
            $i = 0;

            foreach ($result as $key => $value) {
                $resArr[$i]['Nro. Cotización'] = $value->nro_cotizacion;
                $resArr[$i]['Cliente'] = $value->cliente;
                $resArr[$i]['CI'] = $value->ci;
                $resArr[$i]['Ciudad'] = $value->ciudad;
                $resArr[$i]['Género'] = $value->genero;
                $resArr[$i]['Plazo de Crédito'] = $value->plazo_de_credito;
                $resArr[$i]['Forma de Pago'] = $value->forma_de_pago;
                $resArr[$i]['Nro. Crédito'] = $value->numero_credito;
                $resArr[$i]['Usuario'] = $value->usuario;
                $resArr[$i]['Sucursal Regístro'] = $value->sucursal_registro;
                $resArr[$i]['Agencia'] = $value->agencia;
                $resArr[$i]['Auto'] = $value->tipo_vehiculo;
                $resArr[$i]['Modelo'] = $value->modelo;
                $resArr[$i]['Año'] = $value->anio;
                $resArr[$i]['Placa'] = $value->placa;
                $resArr[$i]['0 Km.'] = $value->cero_km;
                $resArr[$i]['Valor Asegurado'] = $value->valor_asegurado.' '.$value->moneda;

                $i++;
            }
            $this->exportXls($resArr, 'Cotizacion', 1, 'A1:Q1');
        }


        # listado de autos registrados por cliente
        foreach ($result as $key => $value) {
            $result[$key]->auDetail = Detail::where('op_au_header_id', $value->id)->get();
        }

        return view('report.cotizacion_auto', compact('result', 'users', 'agencies', 'cities', 'extencion', 'valueForm', 'id_comp'));
    }

    /**
     * 
     * @param type $array
     * @param type $name
     * @param type $key
     */
    public function exportXls($array, $name, $key,$cabecera) {
        $cabecera = ($cabecera)?$cabecera:'A1:M1';
        $edd = new ExportXlsController();
        $edd->arrayObj($array, $name, $key);
        $edd->freezeColumn('A');
        $edd->freezeFila('A2');
        $edd->cabecera($cabecera);
        $edd->exportXls();
    }

    /**
     * funcion retorna ids de polizas emitidas en formato array
     * @param type $object
     * @return type
     */
    public function returnIdHeades($object) {
        $val = array();
        if (count($object) > 0) {
            foreach ($object as $key => $value) {
                $val[] = $value->op_de_header_id;
            }
        }
        return $val;
    }

    /**
     * funcion retorna value para el formulario filtro 
     * @param type $request
     * @return type
     */
    public function addValueForm($request, $rp_state = array()) {
        $request->get('numero_poliza');
        $arr = array(
            'numero_poliza' => ($request->get('numero_poliza')) ? $request->get('numero_poliza') : '',
            'cliente' => ($request->get('cliente')) ? $request->get('cliente') : '',
            'nro_cotizacion' => ($request->get('nro_cotizacion')) ? $request->get('nro_cotizacion') : '',
            'ci' => ($request->get('ci')) ? $request->get('ci') : '',
            'complement' => ($request->get('complement')) ? $request->get('complement') : '',
            'usuario' => ($request->get('usuario')) ? $request->get('usuario') : '',
            'extension' => ($request->get('extension')) ? $request->get('extension') : '',
            'sucursal' => ($request->get('sucursal')) ? $request->get('sucursal') : '',
            'agencia' => ($request->get('agencia')) ? $request->get('agencia') : '',
            'fecha_ini' => ($request->get('fecha_ini')) ? $request->get('fecha_ini') : '',
            'fecha_fin' => ($request->get('fecha_fin')) ? $request->get('fecha_fin') : '',
            'anulado' => ($request->get('anulado')) ? $request->get('anulado') : '',
            'rechazado' => ($request->get('rechazado')) ? $request->get('rechazado') : '',
            'freecover' => ($request->get('freecover')) ? $request->get('freecover') : '',
            'no_freecover' => ($request->get('no_freecover')) ? $request->get('no_freecover') : '',
            'extraprima' => ($request->get('extraprima')) ? $request->get('extraprima') : '',
            'no_extraprima' => ($request->get('no_extraprima')) ? $request->get('no_extraprima') : '',
            'emitido' => ($request->get('emitido')) ? $request->get('emitido') : '',
            'no_emitido' => ($request->get('no_emitido')) ? $request->get('no_emitido') : '',
            'pendiente' => ($request->get('pendiente')) ? $request->get('pendiente') : '',
            'subsanado' => ($request->get('subsanado')) ? $request->get('subsanado') : '',
            'observado' => ($request->get('observado')) ? $request->get('observado') : '',
            'anulados' => ($request->get('anulados')) ? $request->get('anulados') : '3',
        );
        
        # Validacion estado facultativo
        if (count($rp_state) > 0) {
            foreach ($rp_state as $key => $value) {
                $arr[$value->states->slug] = ($request->get($value->states->slug)) ? $request->get($value->states->slug) : '';
            }
        }
        
        return $arr;
    }

}
