<?php

namespace Pondersource\Invoice\CreditNote;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Pondersource\Invoice\Payment\UnitCode;
use Pondersource\Invoice\Item;
use Pondersource\Invoice\Payment\Price;
use Pondersource\Invoice\CreditNote\CreditNotePeriod;
use Pondersource\Invoice\Schema;
use Pondersource\Invoice\CreditNote\GenerateCreditNote;
use Pondersource\Invoice\Tax\TaxTotal;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class CreditNoteLine implements XmlSerializable, XmlDeserializable
{
    private $id;
    private $credidetQuantity;
    private $lineExtensionAmount;
    private $unitCode = UnitCode::UNIT;
    private $taxTotal;
    private $invoicePeriod;
    private $note;
    private $item;
    private $price;
    private $accountingCostCode;
    private $accountingCost;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CreditNoteLine
     */
    public function setId(?string $id): CreditNoteLine
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getCreditedQuantity(): ?float
    {
        return $this->credidetQuantity;
    }

    /**
     * @param float $credidetQuantity
     * @return CreditNoteLine
     */
    public function setCreditedQuantity(?float $credidetQuantity): CreditNoteLine
    {
        $this->credidetQuantity = $credidetQuantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getLineExtensionAmount(): ?float
    {
        return $this->lineExtensionAmount;
    }

    /**
     * @param float $lineExtensionAmount
     * @return CreditNoteLine
     */
    public function setLineExtensionAmount(?float $lineExtensionAmount): CreditNoteLine
    {
        $this->lineExtensionAmount = $lineExtensionAmount;
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
     * @return CreditNoteLine
     */
    public function setTaxTotal(?TaxTotal $taxTotal): CreditNoteLine
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return CreditNoteLine
     */
    public function setNote(?string $note): CreditNoteLine
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return CreditNoteLine
     */
    public function getInvoicePeriod(): ?CreditNoteLine
    {
        return $this->invoicePeriod;
    }

    /**
     * @param CreditNoteLine $invoicePeriod
     * @return CreditNoteLine
     */
    public function setInvoicePeriod(?CreditNoteLine $invoicePeriod)
    {
        $this->invoicePeriod = $invoicePeriod;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return CreditNoteLine
     */
    public function setItem(Item $item): CreditNoteLine
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice(): ?Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     * @return CreditNoteLine
     */
    public function setPrice(?Price $price): CreditNoteLine
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnitCode(): ?string
    {
        return $this->unitCode;
    }

    /**
     * @param string $unitCode
     * @return CreditNoteLine
     */
    public function setUnitCode(?string $unitCode): CreditNoteLine
    {
        $this->unitCode = $unitCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccountingCostCode(): ?string
    {
        return $this->accountingCostCode;
    }

    /**
     * @param string $accountingCostCode
     * @return CreditNoteLine
     */
    public function setAccountingCostCode(?string $accountingCostCode): CreditNoteLine
    {
        $this->accountingCostCode = $accountingCostCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccountingCost(): ?string
    {
        return $this->accountingCost;
    }

    /**
     * @param string $accountingCost
     * @return CreditNoteLine
     */
    public function setAccountingCost(?string $accountingCost): CreditNoteLine
    {
        $this->accountingCost = $accountingCost;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'ID' => $this->id
        ]);

        if (!empty($this->getNote())) {
            $writer->write([
                Schema::CBC . 'Note' => $this->getNote()
            ]);
        }

        $writer->write([
            [
                'name' => Schema::CBC . 'CreditedQuantity',
                'value' => number_format($this->credidetQuantity, 2, '.', ''),
                'attributes' => [
                    'unitCode' => $this->unitCode
                ]
            ],
            [
                'name' => Schema::CBC . 'LineExtensionAmount',
                'value' => number_format($this->lineExtensionAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => GenerateCreditNote::$currencyID
                ]
            ]
        ]);
        if ($this->accountingCostCode !== null) {
            $writer->write([
                Schema::CBC . 'AccountingCostCode' => $this->accountingCostCode
            ]);
        }
        if ($this->accountingCost !== null) {
            $writer->write([
                Schema::CBC . 'AccountingCost' => $this->accountingCost
            ]);
        }
        if ($this->invoicePeriod !== null) {
            $writer->write([
                Schema::CAC . 'InvoicePeriod' => $this->invoicePeriod
            ]);
        }
        if ($this->taxTotal !== null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]);
        }
        $writer->write([
            Schema::CAC . 'Item' => $this->item,
        ]);

        if ($this->price !== null) {
            $writer->write([
                Schema::CAC . 'Price' => $this->price
            ]);
        } else {
            $writer->write([
                Schema::CAC . 'TaxScheme' => null,
            ]);
        }
    }

    /**
     * Deserialize Invoice Line
     */
    static function xmlDeserialize(Reader $reader)
    {
        $invoiceLine = new self();
        
        $keyValue = Sabre\Xml\Element\KeyValue::xmlDeserialize($reader);

        if (isset($keyValue[Schema::CBC . 'ID'])) {
            $invoiceLine->id = $keyValue[Schema::CBC . 'ID'];
        }

        if (isset($keyValue[Schema::CBC . 'Note'])) {
            $invoiceLine->note = $keyValue[Schema::CBC . 'Note'];
        }

        if (isset($keyValue[Schema::CBC . 'CreditedQuantity']) && isset($keyValue[Schema::CBC . 'LineExtensionAmount'])) {
            $invoiceLine->credidetQuantity = $keyValue[Schema::CBC . 'CreditedQuantity'];
            $invoiceLine->lineExtensionAmount = $keyValue[Schema::CBC . 'LineExtensionAmount'];
        }

        if (isset($keyValue[Schema::CBC .'AccountingCostCode'])) {
            $invoiceLine->accountingCostCode = $keyValue[Schema::CBC . 'AccountingCostCode'];
        }

        if (isset($keyValue[Schema::CBC .'AccountingCost'])) {
            $invoiceLine->accountingCost = $keyValue[Schema::CBC . 'AccountingCost'];
        }

        if (isset($keyValue[Schema::CAC . 'InvoicePeriod'])) {
            $invoiceLine->invoicePeriod = $keyValue[Schema::CAC . 'InvoicePeriod'];
        }

        if (isset($keyValue[Schema::CAC . 'TaxTotal'])) {
            $invoiceLine->taxTotal = $keyValue[Schema::CAC . 'TaxTotal'];
        }

        if (isset($keyValue[Schema::CAC . 'Item'])) {
            $invoiceLine->item = $keyValue[Schema::CAC . 'Item'];
        }

        if (isset($keyValue[Schema::CAC . 'Price'])) {
            $invoiceLine->price = $keyValue[Schema::CAC . 'Price'];
        }

        return $invoiceLine;
    }
}
