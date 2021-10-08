<?php

namespace DebugBar\Decorators;

use DebugBar\Entities\DebugBarInformationHolderEntity;
use DebugBar\Enums\OutputDecoratorRenderTypes;

/**
 * Class OutputDecorator
 */
class OutputDecorator extends OutputDecoratorRenderTypes
{
    /**
     * @var DebugBarInformationHolderEntity
     */
    private DebugBarInformationHolderEntity $holderEntities;

    /**
     * @var array
     */
    private array $data;

    /**
     * @param DebugBarInformationHolderEntity $holderEntities
     */
    public function __construct(DebugBarInformationHolderEntity $holderEntities)
    {
        $this->holderEntities = $holderEntities;
    }

    /**
     * @param OutputDecoratorRenderTypes $type
     * @return false|string
     */
    public function decorate(OutputDecoratorRenderTypes $type)
    {
        switch ($type->value) {
            case OutputDecoratorRenderTypes::DECORATE_HTML:
                $output = $this->decorateHtml();

                break;
            case OutputDecoratorRenderTypes::DECORATE_TABLE:
                $output = $this->decorateTable();

                break;
            case OutputDecoratorRenderTypes::DECORATE_ARRAY:
                $output = $this->decorateArray();

                break;
            case OutputDecoratorRenderTypes::DECORATE_JSON:
                $output = $this->decorateJson();

                break;
            default:
                $output = '';
        }

        return $output;
    }

    /**
     * @param array $data
     * @param string $typeHandle
     * @return string
     */
    private static function prepareDataValueArrayForHtml(array $data, string $typeHandle = ''): string
    {
        $html = '';
        foreach ($data as $key => $value) {
            $prepareKey = $key;
            $dataValue  = $value;

            if(is_bool($value)) {
                $dataValue = 'No';

                if($value) {
                    $dataValue = 'Yes';
                }
            }

            if(is_array($value)) {
                $dataValue = implode(' | ', $value);
            }

            if($typeHandle == 'SQL') {
                $prepareKey = $value[0];
                $dataValue  = round($value[1], 4) .'sec';

                if(!empty($value[2])) {
                    $dataValue  .= " | {$value[2]}";
                }
            }

            $html .= "<dd>
                <strong>{$prepareKey}:</strong> {$dataValue}
            </dd>";
        }

        return $html;
    }

    /**
     * @param string $handle
     * @param $value
     * @return string
     */
    private function prepareHtml(string $handle, $value): string
    {
        if(empty($value)) {
            return '';
        }

        $handleList = '';
        if(is_array($value)) {
            $handleList = $this->prepareDataValueArrayForHtml($value, $handle);

            $value = '';
        }

        $html = "<dt>
                <strong>{$handle}:</strong> {$value}
            </dt>";
        $html .= $handleList;

        return $html;
    }

    /**
     * @return string
     */
    private function decorateHtml(): string
    {
        $html = '<div><dl>';
        $html .= $this->prepareHtml('URL', $this->holderEntities->getUrl());
        $html .= $this->prepareHtml('Dispatch', $this->holderEntities->getDispatch());
        $html .= $this->prepareHtml('IP', $this->holderEntities->getClientIP());
        $html .= $this->prepareHtml('Method', $this->holderEntities->getRequestMethod());
        $html .= $this->prepareHtml('POST', $this->holderEntities->getRequestPost());
        $html .= $this->prepareHtml('GET', $this->holderEntities->getRequestGet());
        $html .= $this->prepareHtml('SQL', $this->holderEntities->getSql());
        $html .= $this->prepareHtml('User', $this->holderEntities->getUser());
        $html .= $this->prepareHtml('Memory', $this->holderEntities->getMemory());
        $html .= $this->prepareHtml('Time', $this->holderEntities->getTime());
        $html .= '</dl></div>';

        return $html;
    }

    /**
     * @param $value
     * @param string $typeHandle
     * @return string
     */
    private function prepareTableValue($value, string $typeHandle = ''): string
    {
        $dataValue = '';
        if(is_bool($value)) {
            $dataValue = 'No';

            if($value) {
                $dataValue = 'Yes';
            }
        }

        if(is_array($value) && $typeHandle != 'SQL') {
            foreach ($value as $paramKey => $paramValue) {
                if(is_array($paramValue)) {
                    $paramValue = implode(' | ', $paramValue);
                }

                $dataValue .= "<p><strong>{$paramKey}:</strong> {$paramValue}</p>";
            }
        }

        if($typeHandle == 'SQL') {
            $sqlTypes = [
                'Type',
                'Time',
                'Query'
            ];

            foreach ($value as $sqlValue) {
                foreach ($sqlValue as $qKey => $qValue) {
                    if(!empty($sqlTypes[$qKey]) && $qValue) {
                        $dataValue .= "<p><strong>{$sqlTypes[$qKey]}:</strong> {$qValue}</p>";
                    }
                }
            }
        }

        if(empty($dataValue)) {
            return $value;
        }

        return $dataValue;
    }

    /**
     * @return string
     */
    private function decorateTable(): string
    {
        $this->decorateArray();

        $table = '<table>
            <thead>';

        foreach ($this->data as $thKey => $thValue) {
            if(!empty($thValue)) {
                $table .= "<th>{$thKey}</th>";
            }
        }

        $table .= '</thead>
            <tbody>';

        foreach ($this->data as $tdKey => $tdValue) {
            if(!empty($tdValue)) {
                $dataValue = $this->prepareTableValue($tdValue, $tdKey);

                $table .= "<td>{$dataValue}</td>";
            }
        }

        $table .= '</tbody>
            </table>';

        return $table;
    }

    /**
     * @return array
     */
    private function decorateArray(): array
    {
        $this->data = [
            'URL'      => $this->holderEntities->getUrl(),
            'Dispatch' => $this->holderEntities->getDispatch(),
            'IP'       => $this->holderEntities->getClientIP(),
            'Method'   => $this->holderEntities->getRequestMethod(),
            'POST'     => $this->holderEntities->getRequestPost(),
            'GET'      => $this->holderEntities->getRequestGet(),
            'SQL'      => $this->holderEntities->getSql(),
            'User'     => $this->holderEntities->getUser(),
            'Memory'   => $this->holderEntities->getMemory(),
            'Time'     => $this->holderEntities->getTime()
        ];

        return $this->data;
    }

    /**
     * @return "JSON"
     */
    private function decorateJson()
    {
        $this->decorateArray();

        return json_encode($this->data);
    }
}