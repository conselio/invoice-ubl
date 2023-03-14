<?php

namespace Pondersource\Invoice\CreditNote;

use Pondersource\Invoice\AllowanceCharge;
use Pondersource\Invoice\Documents\AdditionalDocumentReference;
use Pondersource\Invoice\Documents\ContractDocumentReference;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Pondersource\Invoice\Account\Delivery;
use Pondersource\Invoice\Party\Party;
use Pondersource\Invoice\CreditNote\CreditNoteLine;
use Pondersource\Invoice\Legal\LegalMonetaryTotal;
use Pondersource\Invoice\Payment\PaymentTerms;
use Pondersource\Invoice\CreditNote\CreditNotePeriod;
use Pondersource\Invoice\Payment\PaymentMeans;
use Pondersource\Invoice\Payment\OrderReference;
use Pondersource\Invoice\Tax\TaxTotal;
use Pondersource\Invoice\Schema;

use DateTime as DateTime;
use InvalidArgumentException as InvalidArgumentException;
use Pondersource\Invoice\CreditNote\CreditNoteTypeCode;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;


class CreditNote implements XmlSerializable, XmlDeserializable
{
    private $UBLVersionID = '2.1';
    private $customizationID = '1.0';
    private $profileID;
    private $id;
    private $copyIndicator;
    private $issueDate;
    private $creditnoteTypeCode = CreditNoteTypeCode::CREDIT_NOTE;
    private $note;
    private $taxPointDate;
    private $dueDate;
    private $paymentTerms;
    private $accountingSupplierParty;
    private $accountingCustomerParty;
    private $supplierAssignedAccountID;
    private $paymentMeans;
    private $taxTotal;
    private $legalMonetaryTotal;
    private $creditnoteLines;
    private $allowanceCharges;
    private $additionalDocumentReferences;
    private $documentCurrencyCode = 'EUR';
    private $buyerReference;
    private $accountingCostCode;
    private $creditnotePeriod;
    private $delivery;
    private $orderReference;
    private $contractDocumentReference;

    /**
     * @return string
     */
    public function getUBLVersionID(): ?string
    {
        return $this->UBLVersionID;
    }

    /**
     * @param string $UBLVersionID
     * eg. '2.0', '2.1', '2.2', ...
     * @return CreditNote
     */
    public function setUBLVersionID(?string $UBLVersionID): CreditNote
    {
        $this->UBLVersionID = $UBLVersionID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return CreditNote
     */
    public function setId(?string $id): CreditNote
    {
        $this->id = $id;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getCustomizationID(): ?string
    {
        return $this->customizationID;
    }

    /**
     * @param mixed $customizationID
     * @return CreditNote
     */
    public function setCustomizationID(?string $customizationID): CreditNote
    {
        $this->customizationID = $customizationID;
        return $this;
    }

      /**
     * @return mixed
     */
    public function getProfileID(): ?string
    {
        return $this->profileID;
    }

    /**
     * @param mixed $customizationID
     * @return CreditNote
     */
    public function setProfileID(?string $profileID): CreditNote
    {
        $this->profileID = $profileID;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCopyIndicator(): bool
    {
        return $this->copyIndicator;
    }

    /**
     * @param bool $copyIndicator
     * @return CreditNote
     */
    public function setCopyIndicator(bool $copyIndicator): CreditNote
    {
        $this->copyIndicator = $copyIndicator;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getIssueDate(): ?DateTime
    {
        return $this->issueDate;
    }

    /**
     * @param DateTime $issueDate
     * @return CreditNote
     */
    public function setIssueDate(DateTime $issueDate): CreditNote
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    /**
     * @param DateTime $dueDate
     * @return CreditNote
     */
    public function setDueDate(DateTime $dueDate): CreditNote
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param mixed $currencyCode
     * @return CreditNote
     */
    public function setDocumentCurrencyCode(string $currencyCode = 'EUR'): CreditNote
    {
        $this->documentCurrencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreditNoteTypeCode(): ?string
    {
        return $this->creditnoteTypeCode;
    }

    /**
     * @param string $creditnoteTypeCode
     * See also: src/CreditNoteTypeCode.php
     * @return CreditNote
     */
    public function setCreditNoteTypeCode(string $creditnoteTypeCode): CreditNote
    {
        $this->creditnoteTypeCode = $creditnoteTypeCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return CreditNote
     */
    public function setNote(string $note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTaxPointDate(): ?DateTime
    {
        return $this->taxPointDate;
    }

    /**
     * @param DateTime $taxPointDate
     * @return CreditNote
     */
    public function setTaxPointDate(DateTime $taxPointDate): CreditNote
    {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }

    /**
     * @return PaymentTerms
     */
    public function getPaymentTerms(): ?PaymentTerms
    {
        return $this->paymentTerms;
    }

    /**
     * @param PaymentTerms $paymentTerms
     * @return CreditNote
     */
    public function setPaymentTerms(PaymentTerms $paymentTerms): CreditNote
    {
        $this->paymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingSupplierParty(): ?Party
    {
        return $this->accountingSupplierParty;
    }

    /**
     * @param Party $accountingSupplierParty
     * @return CreditNote
     */
    public function setAccountingSupplierParty(Party $accountingSupplierParty): CreditNote
    {
        $this->accountingSupplierParty = $accountingSupplierParty;
        return $this;
    }

    /**
     * @return Party
     */
    public function getSupplierAssignedAccountID(): ?string
    {
        return $this->supplierAssignedAccountID;
    }

    /**
     * @param string $supplierAssignedAccountID
     * @return CreditNote
     */
    public function setSupplierAssignedAccountID(string $supplierAssignedAccountID): CreditNote
    {
        $this->supplierAssignedAccountID = $supplierAssignedAccountID;
        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingCustomerParty(): ?Party
    {
        return $this->accountingCustomerParty;
    }

    /**
     * @param Party $accountingCustomerParty
     * @return CreditNote
     */
    public function setAccountingCustomerParty(Party $accountingCustomerParty): CreditNote
    {
        $this->accountingCustomerParty = $accountingCustomerParty;
        return $this;
    }

    /**
     * @return PaymentMeans
     */
    public function getPaymentMeans(): ?PaymentMeans
    {
        return $this->paymentMeans;
    }

    /**
     * @param PaymentMeans $paymentMeans
     * @return CreditNote
     */
    public function setPaymentMeans(PaymentMeans $paymentMeans): CreditNote
    {
        $this->paymentMeans = $paymentMeans;
        return $this;
    }

    /**
     * @return TaxTotal
     */
    public function getTaxTotal(): ?TaxTotal
    {
        return $this->taxTotal;
    }

    /**
     * @param TaxTotal $taxTotal
     * @return CreditNote
     */
    public function setTaxTotal(TaxTotal $taxTotal): CreditNote
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * @return LegalMonetaryTotal
     */
    public function getLegalMonetaryTotal(): ?LegalMonetaryTotal
    {
        return $this->legalMonetaryTotal;
    }

    /**
     * @param LegalMonetaryTotal $legalMonetaryTotal
     * @return CreditNote
     */
    public function setLegalMonetaryTotal(LegalMonetaryTotal $legalMonetaryTotal): CreditNote
    {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        return $this;
    }

    /**
     * @return CreditNoteLine[]
     */
    public function getCreditNoteLines(): ?array
    {
        return $this->creditnoteLines;
    }

    /**
     * @param CreditNoteLine[] $creditnoteLines
     * @return CreditNote
     */
    public function setCreditNoteLines(array $creditnoteLines): CreditNote
    {
        $this->creditnoteLines = $creditnoteLines;
        return $this;
    }

    /**
     * @return AllowanceCharge[]
     */
    public function getAllowanceCharges(): ?AllowanceCharge
    {
        return $this->allowanceCharges;
    }

    /**
     * @param AllowanceCharge[] $allowanceCharges
     * @return CreditNote
     */
    public function setAllowanceCharges(AllowanceCharge $allowanceCharges): CreditNote
    {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }

    /**
     * @return AdditionalDocumentReference
     */
    public function getAdditionalDocumentReference(): ?AdditionalDocumentReference
    {
        return $this->additionalDocumentReferences;
    }

    /**
     * @param AdditionalDocumentReference $additionalDocumentReference
     * @return CreditNote
     */
    public function setAdditionalDocumentReference(AdditionalDocumentReference $additionalDocumentReferences): CreditNote
    {
        $this->additionalDocumentReferences = $additionalDocumentReferences;
        return $this;
    }

    /**
     * @param string $buyerReference
     * @return CreditNote
     */
    public function setByerReference(string $buyerReference): CreditNote
    {
        $this->buyerReference = $buyerReference;
        return $this;
    }

      /**
     * @return string buyerReference
     */
    public function getBuyerReference(): ?string
    {
        return $this->buyerReference;
    }

    /**
     * @return mixed
     */
    public function getAccountingCostCode(): ?string
    {
        return $this->accountingCostCode;
    }

    /**
     * @param mixed $accountingCostCode
     * @return CreditNote
     */
    public function setAccountingCostCode(string $accountingCostCode): CreditNote
    {
        $this->accountingCostCode = $accountingCostCode;
        return $this;
    }

    /**
     * @return CreditNotePeriod
     */
    public function getCreditNoteLinePeriod(): ?CreditNotePeriod
    {
        return $this->creditnotePeriod;
    }

    /**
     * @param CreditNotePeriod $creditnotePeriod
     * @return CreditNote
     */
    public function setCreditNotePeriod(CreditNotePeriod $creditnotePeriod): CreditNote
    {
        $this->creditnotePeriod = $creditnotePeriod;
        return $this;
    }

    /**
     * @return Delivery
     */
    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    /**
     * @param Delivery $delivery
     * @return CreditNote
     */
    public function setDelivery(Delivery $delivery): CreditNote
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * @return OrderReference
     */
    public function getOrderReference(): ?OrderReference
    {
        return $this->orderReference;
    }

    /**
     * @param OrderReference $orderReference
     * @return CreditNote
     */
    public function setOrderReference(OrderReference $orderReference): CreditNote
    {
        $this->orderReference = $orderReference;
        return $this;
    }

    /**
     * @return ContractDocumentReference
     */
    public function getContractDocumentReference(): ?ContractDocumentReference
    {
        return $this->contractDocumentReference;
    }

    /**
     * @param string $ContractDocumentReference
     * @return CreditNote
     */
    public function setContractDocumentReference(ContractDocumentReference $contractDocumentReference): CreditNote
    {
        $this->contractDocumentReference = $contractDocumentReference;
        return $this;
    }

    /**
     * The validate function that is called during xml writing to valid the data of the object.
     *
     * @return void
     * @throws InvalidArgumentException An error with information about required data that is missing to write the XML
     */
    public function validate()
    {
        if ($this->id === null) {
            throw new InvalidArgumentException('Missing creditnote id');
        }

        if (!$this->issueDate instanceof DateTime) {
            throw new InvalidArgumentException('Invalid creditnote issueDate');
        }

        if ($this->creditnoteTypeCode === null) {
            throw new InvalidArgumentException('Missing creditnote creditnoteTypeCode');
        }

        if ($this->accountingSupplierParty === null) {
            throw new InvalidArgumentException('Missing creditnote accountingSupplierParty');
        }

        if ($this->accountingCustomerParty === null) {
            throw new InvalidArgumentException('Missing creditnote accountingCustomerParty');
        }

        if ($this->creditnoteLines === null) {
            throw new InvalidArgumentException('Missing creditnote lines');
        }

        if ($this->legalMonetaryTotal === null) {
            throw new InvalidArgumentException('Missing creditnote LegalMonetaryTotal');
        }
    }

    /**
     * The xmlSerialize method is called during xml writing.
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $this->validate();

        $writer->write([
            Schema::CBC . 'UBLVersionID' => $this->UBLVersionID,
            Schema::CBC . 'CustomizationID' => $this->customizationID,
            Schema::CBC . 'ProfileID' => $this->profileID,
            Schema::CBC . 'ID' => $this->id
        ]);

        if ($this->copyIndicator !== null) {
            $writer->write([
                Schema::CBC . 'CopyIndicator' => $this->copyIndicator ? 'true' : 'false'
            ]);
        }

        $writer->write([
            Schema::CBC . 'IssueDate' => $this->issueDate->format('Y-m-d'),
        ]);

        if ($this->dueDate !== null) {
            $writer->write([
                Schema::CBC . 'DueDate' => $this->dueDate->format('Y-m-d')
            ]);
        }

        if ($this->creditnoteTypeCode !== null) {
            $writer->write([
                Schema::CBC . 'CreditNoteTypeCode' => $this->creditnoteTypeCode
            ]);
        }

        if ($this->note !== null) {
            $writer->write([
                Schema::CBC . 'Note' => $this->note
            ]);
        }

        if ($this->taxPointDate !== null) {
            $writer->write([
                Schema::CBC . 'TaxPointDate' => $this->taxPointDate->format('Y-m-d')
            ]);
        }

        $writer->write([
            Schema::CBC . 'DocumentCurrencyCode' => $this->documentCurrencyCode,
        ]);

        if ($this->accountingCostCode !== null) {
            $writer->write([
                Schema::CBC . 'AccountingCost' => $this->accountingCostCode
            ]);
        }

        if ($this->buyerReference != null) {
            $writer->write([
                Schema::CBC . 'BuyerReference' => $this->buyerReference
            ]);
        }

        if ($this->contractDocumentReference !== null) {
            $writer->write([
                Schema::CAC . 'ContractDocumentReference' => $this->contractDocumentReference,
            ]);
        }

        if ($this->creditnotePeriod != null) {
            $writer->write([
                Schema::CAC . 'CreditNotePeriod' => $this->creditnotePeriod
            ]);
        }

        if ($this->orderReference != null) {
            $writer->write([
                Schema::CAC . 'OrderReference' => $this->orderReference
            ]);
        }

        if (!empty($this->additionalDocumentReferences)) {
                $writer->write([
                    Schema::CAC . 'AdditionalDocumentReference' => $this->additionalDocumentReferences
                ]);
        }

        if ($this->supplierAssignedAccountID !== null) {
            $customerParty = [
                Schema::CBC . 'SupplierAssignedAccountID' => $this->supplierAssignedAccountID,
                Schema::CAC . "Party" => $this->accountingCustomerParty
            ];
        } else {
            $customerParty = [
                Schema::CAC . "Party" => $this->accountingCustomerParty
            ];
        }

        $writer->write([
            Schema::CAC . 'AccountingSupplierParty' => [Schema::CAC . "Party" => $this->accountingSupplierParty],
            Schema::CAC . 'AccountingCustomerParty' => $customerParty,
        ]);

        if ($this->delivery != null) {
            $writer->write([
                Schema::CAC . 'Delivery' => $this->delivery
            ]);
        }

        if ($this->paymentMeans !== null) {
            $writer->write([
                Schema::CAC . 'PaymentMeans' => $this->paymentMeans
            ]);
        }

        if ($this->paymentTerms !== null) {
            $writer->write([
                Schema::CAC . 'PaymentTerms' => $this->paymentTerms
            ]);
        }

        if ($this->allowanceCharges !== null) {
            //foreach ($this->allowanceCharges as $allowanceCharge) {
                $writer->write([
                    Schema::CAC . 'AllowanceCharge' => $this->allowanceCharges
                ]);
            //}
        }

        if ($this->taxTotal !== null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]);
        }

        $writer->write([
            Schema::CAC . 'LegalMonetaryTotal' => $this->legalMonetaryTotal
        ]);

        foreach ($this->creditnoteLines as $creditnote) {
            $writer->write([
                Schema::CAC . 'CreditNoteLine' => $creditnote
            ]);
        }
    }

    /**
     * Deserialize CreditNote
     */
    static function xmlDeserialize(Reader $reader)
    {



        $creditnote = new self();

        $keyValue = Sabre\Xml\Element\KeyValue::xmlDeserialize($reader);

        if (isset($keyValue[Schema::CBC . 'UBLVersionID'])) {
            $creditnote->UBLVersionID = $keyValue[Schema::CBC . 'UBLVersionID'];
        }

        if (isset($keyValue[Schema::CBC . 'CustomizationID'])) {
            $creditnote->customizationID = $keyValue[Schema::CBC . 'CustomizationID'];
        }

        if (isset($keyValue[Schema::CBC . 'ProfileID'])) {
            $creditnote->profileID = $keyValue[Schema::CBC . 'ProfileID'];
        }

        if (isset($keyValue[Schema::CBC . 'ID'])) {
            $creditnote->id = $keyValue[Schema::CBC . 'ID'];
        }

        if (isset($keyValue[Schema::CBC . 'CopyIndicator'])) {
            $creditnote->copyIndicator = $keyValue[Schema::CBC . 'CopyIndicator'];
        }

        if (isset($keyValue[Schema::CBC . 'IssueDate'])) {
            $creditnote->issueDate = $keyValue[Schema::CBC . 'IssueDate'];
        }

        if (isset($keyValue[Schema::CBC . 'DueDate'])) {
            $creditnote->dueDate = $keyValue[Schema::CBC . 'DueDate'];
        }

        if (isset($keyValue[Schema::CBC . 'CreditNoteTypeCode'])) {
            $creditnote->creditnoteTypeCode = $keyValue[Schema::CBC . 'CreditNoteTypeCode'];
        }

        if (isset($keyValue[Schema::CBC . 'Note'])) {
            $creditnote->note = $keyValue[Schema::CBC . 'Note'];
        }

        if (isset($keyValue[Schema::CBC . 'TaxPointDate'])) {
            $creditnote->taxPointDate = $keyValue[Schema::CBC . 'TaxPointDate'];
        }

        if (isset($keyValue[Schema::CBC . 'DocumentCurrencyCode'])) {
            $creditnote->documentCurrencyCode = $keyValue[Schema::CBC . 'DocumentCurrencyCode'];
        }

        if (isset($keyValue[Schema::CAC . 'ContractDocumentReference'])) {
            $creditnote->contractDocumentReference = $keyValue[Schema::CAC . 'ContractDocumentReference'];
        }

        if (isset($keyValue[Schema::CAC . 'CreditNotePeriod'])) {
            $creditnote->creditnotePeriod = $keyValue[Schema::CAC . 'CreditNotePeriod'];
        }

        if (isset($keyValue[Schema::CAC . 'OrderReference'])) {
            $creditnote->orderReference = $keyValue[Schema::CAC . 'OrderReference'];
        }

        if (isset($keyValue[Schema::CAC . 'AdditionalDocumentReference'])) {
            $creditnote->additionalDocumentReferences = $keyValue[Schema::CAC . 'AdditionalDocumentReference'];
        }

        if (isset($keyValue[Schema::CAC . 'AdditionalDocumentReference'])) {
            $creditnote->additionalDocumentReferences = $keyValue[Schema::CAC . 'AdditionalDocumentReference'];
        }


//
//        if (isset($keyValue[Schema::CAC . 'AccountingSupplierParty' . [Schema::CAC . "Party"]])) {
//            $creditnote->accountingSupplierParty = $keyValue[Schema::CAC . 'AccountingSupplierParty' . [Schema::CAC . "Party"]];
//        }
//
//        if (isset($keyValue[Schema::CAC . 'AccountingCustomerParty' . [Schema::CAC . "Party"]])) {
//            $creditnote->AccountingCustomerParty = $keyValue[Schema::CAC . 'AccountingCustomerParty' . [Schema::CAC . "Party"]];
//        }

        if (isset($keyValue[Schema::CAC . 'Delivery'])) {
            $creditnote->delivery = $keyValue[Schema::CAC . 'Delivery'];
        }

        if (isset($keyValue[Schema::CAC . 'PaymentMeans'])) {
            $creditnote->paymentMeans = $keyValue[Schema::CAC . 'PaymentMeans'];
        }

        if (isset($keyValue[Schema::CAC . 'PaymentTerms'])) {
            $creditnote->paymentTerms = $keyValue[Schema::CAC . 'PaymentTerms'];
        }

        if (isset($keyValue[Schema::CAC . 'AllowanceCharge'])) {
            $creditnote->allowanceCharges = $keyValue[Schema::CAC . 'AllowanceCharge'];
        }

        if (isset($keyValue[Schema::CAC . 'TaxTotal'])) {
            $creditnote->taxTotal = $keyValue[Schema::CAC . 'TaxTotal'];
        }

        if (isset($keyValue[Schema::CAC . 'LegalMonetaryTotal'])) {
            $creditnote->legalMonetaryTotal = $keyValue[Schema::CAC . 'LegalMonetaryTotal'];
        }

        if (isset($keyValue[Schema::CAC . 'CreditNoteLine'])) {
            $creditnote->creditnoteLines = $keyValue[Schema::CAC . 'CreditNoteLine'];
        }
        return $creditnote;
    }
}
