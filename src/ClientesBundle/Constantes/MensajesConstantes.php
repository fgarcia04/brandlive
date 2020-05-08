<?php


namespace ClientesBundle\Constantes;


class MensajesConstantes
{
    const TYPE_MESSAGE = 'success';
    const TEXT_MESSAGE_ADD = 'Se agregó correctamente el cliente';
    const TEXT_MESSAGE_UPDATE = 'Se editó correctamente el cliente';
    const TEXT_MESSAGE_DELETE = 'Se eliminó correctamente el cliente';
    const TEXT_NOT_FOUND_CLIENT = 'No se encontró el cliente.';
    const TEXT_ERROR = 'Ocurrio un error. Reintente de nuevo o comunicarse con Sistemas.';
    const HTTP_CODE = 500;
    const ALERT_SUCCESS = 'success';
    const ALERT_INFO = 'info';
    const ALERT_DANGER = 'danger';

    static public function generateResponse($message, $httpCode, $data = array()){
        switch ($httpCode) {
            case 200:
                $classHtml = self::ALERT_SUCCESS;
                break;
            case 404:
                $classHtml = self::ALERT_INFO;
                break;
            default:
                $classHtml = self::ALERT_DANGER;
                $message = self::TEXT_ERROR;
                $httpCode = self::HTTP_CODE;
                break;
        }
        return array("response" => array("message" => $message,"data" => $data,"class" => $classHtml), "httpCode" => $httpCode);
    }

}