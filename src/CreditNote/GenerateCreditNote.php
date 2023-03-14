<?php

namespace Pondersource\Invoice\CreditNote;

use Sabre\Xml\Service;

class GenerateCreditNote
{
    public static $currencyID;

    public static function creditnote(CreditNote $creditnote, $currencyId = 'EUR')
    {
        self::$currencyID = $currencyId;

        $xmlService = new Service();

        $xmlService->namespaceMap = [
            'urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2' => '',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac'
        ];

        return $xmlService->write('CreditNote', [
            $creditnote
        ]);
    }
}
