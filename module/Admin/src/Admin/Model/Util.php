<?php

/*
 * Author: Paulo Roberto Silla - paulo.silla@embrapa.br
 */
namespace Admin\Model;

use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime;

class Util 
{
    /*
     * @return Array contendo os nomes dos Estados brasileiros identificados 
     * por suas siglas (UF)
     */
    public static function getEstadosBr() 
    {
        return array(
            '' => '--- Escolha um Estado ---',
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AM'=>'Amazonas',
            'AP'=>'Amapá',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RO'=>'Rondônia',
            'RS'=>'Rio Grande do Sul',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SE'=>'Sergipe',
            'SP'=>'São Paulo',
            'TO'=>'Tocantins'
        );
    }
    
    /*
     * Converte a data para os formatos AAAA/MM/DD e DD/MM/AAAA
     * @param string $data - data no formato AAAA/MM/DD ou DD/MM/AAAA
     * @return string (data convertida)
     */
    
    public static function converteData($data) 
    {
        $data = str_replace("-","/",$data);
        $data_aux = explode("/", $data);
        return $data_aux[2]."/".$data_aux[1]."/".$data_aux[0];
    }
    
    /*
     * Envio de e-mails do sistema
     */
    
    public function enviaEmail($nomedestino, $emaildestino, $assunto, $textohtml, $texto, $pathanexo, $tipoanexo)
    {
        $htmlPart = new MimePart($textohtml);
        $htmlPart->type = "text/html";

        $textPart = new MimePart($texto);
        $textPart->type = "text/plain";
        
        $body = new MimeMessage();
        
        //envio de anexo
        if ($pathanexo != "") {
        	
        	$attachment = new MimePart(fopen(__DIR__."/../../../../../public/reports/cadastro-amostras.csv", 'r'));
        	$attachment->type = 'text/csv';
        	$attachment->encoding 	= Mime::ENCODING_BASE64;
        	$attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
        	$attachment->filename	= "cadastro-amostras.csv";
            $body->setParts(array($textPart, $htmlPart, $attachment));
        } else {
	        $body->setParts(array($textPart, $htmlPart));
        }

        $message = new Mail\Message();
        $message->setFrom('no-replay@cnpso.embrapa.br', 'No-replay cnpso');
        $message->addTo($emaildestino, $nomedestino);
//                 $message->setSender($sender);
        $message->setSubject($assunto);
        $message->setEncoding("UTF-8");
        $message->setBody($body);
        $message->getHeaders()->get('content-type')->setType('multipart/alternative');

//            $transport = new Mail\Transport\Sendmail();
//            $transport->send($message);            

        // Setup SMTP transport
        $transport = new Mail\Transport\Smtp();
        $options   = new Mail\Transport\SmtpOptions(array(
//             'name' => 'salmao.cnpso.embrapa.br',
//             'host' => '192.168.159.2',
//             'port' => 25,
       		'name' => 'zmta-uds.sede.embrapa.br',
       		'host' => '200.202.168.83',
       		'port' => 25,
        		
        ));
        $transport->setOptions($options);
        $transport->send($message);            
    }
    
    /*
     * Recebe um valor decimal no formato 999.999.999,99 (máscara de entrada na 
     * tela) e o converte para  o formato 999999999.99 (padrão do banco de dados)
     */
    public static function converteDecimal($valor) {
        $valor = str_replace(".", "", $valor);
        return (float) str_replace(",", ".", $valor);
    }

    /*
     * Recebe um array ordenado com inteiros e devolve uma string resumida, com os intervalos. Ex.:
     * Parametro de entrada: array([1,2,3,5,6,7,10,11,12,15])
     * Saída: "1-3, 5-7, 10-12, 15"
     */
    public static function resumo($dados) {
    	$string = "";
    	$inicio = true;
    	
    	foreach ($dados as $key => $d) {
    		$em_uso = false;
    		if ($inicio) {
    			if ($string != "") $string .=", ";
    			$string .= $d;
    			$inicio = false;
    			$em_uso = true;
    		}
    		if(isset($dados[$key+1])) {
    			$proximo = intval($d) +1;
    			if (intval($dados[$key+1]) != $proximo) {
    				$string .="-".$d;
    				$inicio = true;
    			}
    		} else if (!$em_uso) {
    			$string.= "-".$d;
    		}
    	}
    	return $string;
    }
}
