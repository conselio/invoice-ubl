<?php

namespace Pondersource\Invoice\Invoice;

use Pondersource\Invoice\AllowanceCharge;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Pondersource\Invoice\Account\Delivery;
use Pondersource\Invoice\Party\Party;
use Pondersource\Invoice\Invoice\InvoiceLine;
use Pondersource\Invoice\Legal\LegalMonetaryTotal;
use Pondersource\Invoice\Payment\PaymentTerms;
use Pondersource\Invoice\Invoice\InvoicePeriod;
use Pondersource\Invoice\Payment\PaymentMeans;
use Pondersource\Invoice\Payment\OrderReference;
use Pondersource\Invoice\Tax\TaxTotal;
use Pondersource\Invoice\Schema;

use DateTime as DateTime;
use InvalidArgumentException as InvalidArgumentException;
use Pondersource\Invoice\Invoice\InvoiceTypeCode;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;


class Invoice implements XmlSerializable, XmlDeserializable
{
    private $UBLVersionID = '2.1';
    private $customizationID = '1.0';
    private $profileID;
    private $id;
    private $copyIndicator;
    private $issueDate;
    private $invoiceTypeCode = InvoiceTypeCode::INVOICE;
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
    private $invoiceLines;
    private $allowanceCharges;
    private $additionalDocumentReferences;
    private $documentCurrencyCode = 'EUR';
    private $buyerReference;
    private $accountingCostCode;
    private $invoicePeriod;
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
     * @return Invoice
     */
    public function setUBLVersionID(?string $UBLVersionID): Invoice
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
     * @return Invoice
     */
    public function setId(?string $id): Invoice
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
     * @return Invoice
     */
    public function setCustomizationID(?string $customizationID): Invoice
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
     * @return Invoice
     */
    public function setProfileID(?string $profileID): Invoice
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
     * @return Invoice
     */
    public function setCopyIndicator(bool $copyIndicator): Invoice
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
     * @return Invoice
     */
    public function setIssueDate(DateTime $issueDate): Invoice
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
     * @return Invoice
     */
    public function setDueDate(DateTime $dueDate): Invoice
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param mixed $currencyCode
     * @return Invoice
     */
    public function setDocumentCurrencyCode(string $currencyCode = 'EUR'): Invoice
    {
        $this->documentCurrencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceTypeCode(): ?string
    {
        return $this->invoiceTypeCode;
    }

    /**
     * @param string $invoiceTypeCode
     * See also: src/InvoiceTypeCode.php
     * @return Invoice
     */
    public function setInvoiceTypeCode(string $invoiceTypeCode): Invoice
    {
        $this->invoiceTypeCode = $invoiceTypeCode;
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
     * @return Invoice
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
     * @return Invoice
     */
    public function setTaxPointDate(DateTime $taxPointDate): Invoice
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
     * @return Invoice
     */
    public function setPaymentTerms(PaymentTerms $paymentTerms): Invoice
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
     * @return Invoice
     */
    public function setAccountingSupplierParty(Party $accountingSupplierParty): Invoice
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
     * @return Invoice
     */
    public function setSupplierAssignedAccountID(string $supplierAssignedAccountID): Invoice
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
     * @return Invoice
     */
    public function setAccountingCustomerParty(Party $accountingCustomerParty): Invoice
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
     * @return Invoice
     */
    public function setPaymentMeans(PaymentMeans $paymentMeans): Invoice
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
     * @return Invoice
     */
    public function setTaxTotal(TaxTotal $taxTotal): Invoice
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
     * @return Invoice
     */
    public function setLegalMonetaryTotal(LegalMonetaryTotal $legalMonetaryTotal): Invoice
    {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        return $this;
    }

    /**
     * @return InvoiceLine[]
     */
    public function getInvoiceLines(): ?array
    {
        return $this->invoiceLines;
    }

    /**
     * @param InvoiceLine[] $invoiceLines
     * @return Invoice
     */
    public function setInvoiceLines(array $invoiceLines): Invoice
    {
        $this->invoiceLines = $invoiceLines;
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
     * @return Invoice
     */
    public function setAllowanceCharges(array $allowanceCharges): Invoice
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
     * @return Invoice
     */
    public function setAdditionalDocumentReference(AdditionalDocumentReference $additionalDocumentReferences): Invoice
    {
        $this->additionalDocumentReferences = $additionalDocumentReferences;
        return $this;
    }

    /**
     * @param string $buyerReference
     * @return Invoice
     */
    public function setByerReference(string $buyerReference): Invoice
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
     * @return Invoice
     */
    public function setAccountingCostCode(string $accountingCostCode): Invoice
    {
        $this->accountingCostCode = $accountingCostCode;
        return $this;
    }

    /**
     * @return InvoicePeriod
     */
    public function getInvoicePeriod(): ?InvoicePeriod
    {
        return $this->invoicePeriod;
    }

    /**
     * @param InvoicePeriod $invoicePeriod
     * @return Invoice
     */
    public function setInvoicePeriod(InvoicePeriod $invoicePeriod): Invoice
    {
        $this->invoicePeriod = $invoicePeriod;
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
     * @return Invoice
     */
    public function setDelivery(Delivery $delivery): Invoice
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
     * @return Invoice
     */
    public function setOrderReference(OrderReference $orderReference): Invoice
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
     * @return Invoice
     */
    public function setContractDocumentReference(ContractDocumentReference $contractDocumentReference): Invoice
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
            throw new InvalidArgumentException('Missing invoice id');
        }

        if (!$this->issueDate instanceof DateTime) {
            throw new InvalidArgumentException('Invalid invoice issueDate');
        }

        if ($this->invoiceTypeCode === null) {
            throw new InvalidArgumentException('Missing invoice invoiceTypeCode');
        }

        if ($this->accountingSupplierParty === null) {
            throw new InvalidArgumentException('Missing invoice accountingSupplierParty');
        }

        if ($this->accountingCustomerParty === null) {
            throw new InvalidArgumentException('Missing invoice accountingCustomerParty');
        }

        if ($this->invoiceLines === null) {
            throw new InvalidArgumentException('Missing invoice lines');
        }

        if ($this->legalMonetaryTotal === null) {
            throw new InvalidArgumentException('Missing invoice LegalMonetaryTotal');
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

        if ($this->invoiceTypeCode !== null) {
            $writer->write([
                Schema::CBC . 'InvoiceTypeCode' => $this->invoiceTypeCode
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

        if ($this->invoicePeriod != null) {
            $writer->write([
                Schema::CAC . 'InvoicePeriod' => $this->invoicePeriod
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

        foreach ($this->invoiceLines as $invoiceLine) {
            $writer->write([
                Schema::CAC . 'InvoiceLine' => $invoiceLine
            ]);
        }
    }

    /**
     * Deserialize Invoice
     */
    static function xmlDeserialize(Reader $reader)
    {
        $invoice = new self();

        $keyValue = Sabre\Xml\Element\KeyValue::xmlDeserialize($reader);

        if (isset($keyValue[Schema::CBC . 'UBLVersionID'])) {
            $invoice->UBLVersionID = $keyValue[Schema::CBC . 'UBLVersionID'];
        }

        if (isset($keyValue[Schema::CBC . 'CustomizationID'])) {
            $invoice->customizationID = $keyValue[Schema::CBC . 'CustomizationID'];
        }

        if (isset($keyValue[Schema::CBC . 'ProfileID'])) {
            $invoice->profileID = $keyValue[Schema::CBC . 'ProfileID'];
        }

        if (isset($keyValue[Schema::CBC . 'ID'])) {
            $invoice->id = $keyValue[Schema::CBC . 'ID'];
        }

        if (isset($keyValue[Schema::CBC . 'CopyIndicator'])) {
            $invoice->copyIndicator = $keyValue[Schema::CBC . 'CopyIndicator'];
        }

        if (isset($keyValue[Schema::CBC . 'IssueDate'])) {
            $invoice->issueDate = $keyValue[Schema::CBC . 'IssueDate'];
        }

        if (isset($keyValue[Schema::CBC . 'DueDate'])) {
            $invoice->dueDate = $keyValue[Schema::CBC . 'DueDate'];
        }

        if (isset($keyValue[Schema::CBC . 'InvoiceTypeCode'])) {
            $invoice->invoiceTypeCode = $keyValue[Schema::CBC . 'InvoiceTypeCode'];
        }

        if (isset($keyValue[Schema::CBC . 'Note'])) {
            $invoice->note = $keyValue[Schema::CBC . 'Note'];
        }

        if (isset($keyValue[Schema::CBC . 'TaxPointDate'])) {
            $invoice->taxPointDate = $keyValue[Schema::CBC . 'TaxPointDate'];
        }

        if (isset($keyValue[Schema::CBC . 'DocumentCurrencyCode'])) {
            $invoice->documentCurrencyCode = $keyValue[Schema::CBC . 'DocumentCurrencyCode'];
        }

        if (isset($keyValue[Schema::CAC . 'ContractDocumentReference'])) {
            $invoice->contractDocumentReference = $keyValue[Schema::CAC . 'ContractDocumentReference'];
        }

        if (isset($keyValue[Schema::CAC . 'InvoicePeriod'])) {
            $invoice->invoicePeriod = $keyValue[Schema::CAC . 'InvoicePeriod'];
        }

        if (isset($keyValue[Schema::CAC . 'OrderReference'])) {
            $invoice->orderReference = $keyValue[Schema::CAC . 'OrderReference'];
        }

        if (isset($keyValue[Schema::CAC . 'AdditionalDocumentReference'])) {
            $invoice->additionalDocumentReferences = $keyValue[Schema::CAC . 'AdditionalDocumentReference'];
        }

        if (isset($keyValue[Schema::CAC . 'AdditionalDocumentReference'])) {
            $invoice->additionalDocumentReferences = $keyValue[Schema::CAC . 'AdditionalDocumentReference'];
        }

        if (isset($keyValue[Schema::CAC . 'AccountingSupplierParty' . [Schema::CAC . "Party"]])) {
            $invoice->accountingSupplierParty = $keyValue[Schema::CAC . 'AccountingSupplierParty' . [Schema::CAC . "Party"]];
        }

        if (isset($keyValue[Schema::CAC . 'AccountingCustomerParty' . [Schema::CAC . "Party"]])) {
            $invoice->AccountingCustomerParty = $keyValue[Schema::CAC . 'AccountingCustomerParty' . [Schema::CAC . "Party"]];
        }

        if (isset($keyValue[Schema::CAC . 'Delivery'])) {
            $invoice->delivery = $keyValue[Schema::CAC . 'Delivery'];
        }

        if (isset($keyValue[Schema::CAC . 'PaymentMeans'])) {
            $invoice->paymentMeans = $keyValue[Schema::CAC . 'PaymentMeans'];
        }

        if (isset($keyValue[Schema::CAC . 'PaymentTerms'])) {
            $invoice->paymentTerms = $keyValue[Schema::CAC . 'PaymentTerms'];
        }

        if (isset($keyValue[Schema::CAC . 'AllowanceCharge'])) {
            $invoice->allowanceCharges = $keyValue[Schema::CAC . 'AllowanceCharge'];
        }

        if (isset($keyValue[Schema::CAC . 'TaxTotal'])) {
            $invoice->taxTotal = $keyValue[Schema::CAC . 'TaxTotal'];
        }

        if (isset($keyValue[Schema::CAC . 'LegalMonetaryTotal'])) {
            $invoice->legalMonetaryTotal = $keyValue[Schema::CAC . 'LegalMonetaryTotal'];
        }

        if (isset($keyValue[Schema::CAC . 'InnvoiceLine'])) {
            $invoice->invoiceLines = $keyValue[Schema::CAC . 'InnvoiceLine'];
        }
        return $invoice;
    }
}
