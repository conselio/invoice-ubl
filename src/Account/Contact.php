<?php

namespace Pondersource\Invoice\Account;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;
use Pondersource\Invoice\Schema;

class Contact implements XmlSerializable, XmlDeserializable
{
    private $name;
    private $telephone;
    private $telefax;
    private $electronicMail;
    

    /**
     * Get Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set Name
     */
    public function setName(?string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get telephone
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }


    /**
     * get telefax
     */
    public function getTelefax(): ?string
    {
        return $this->telefax;
    }

    /**
     * set telefax
     */
    public function setTelefax(?string $telefax): Contact
    {
        $this->telefax = $telefax;
        return $this;
    }

    /**
     * Set telephone
     */
    public function setTelephone(?string $telephone): Contact
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * get electroic Mail
     */
    public function getElectronicMail(): ?string
    {
        return $this->electronicMail;
    }

    /**
     * Set electronic mail
     */
    public function setElectronicMail(?string $electronicMail): Contact
    {
        $this->electronicMail = $electronicMail;
        return $this;
    }

    /**
     * Serialize Contact
     */
    public function xmlSerialize(Writer $writer)
    {
        if ($this->name !== null) {
            $writer->write([
                Schema::CBC . 'Name' => $this->name
            ]);
        }

        if ($this->telephone !== null) {
            $writer->write([
                Schema::CBC . 'Telephone' => $this->telephone
            ]);
        }
        
        if ($this->telefax !== null) {
            $writer->write([
                Schema::CBC . 'Telefax' => $this->telefax
            ]);
        }

        if ($this->electronicMail !== null) {
            $writer->write([
                Schema::CBC . 'ElectronicMail' => $this->electronicMail
            ]);
        }
    }

    /**
     * Deserialize Contact
     */
    static function xmlDeserialize(Reader $reader)
    {
        $contact = new self();
        $keyValue =  Sabre\Xml\Element\KeyValue::xmlDeserialize($reader);

        if (isset($keyValue[Schema::CBC .'Name'])) {
            $contact->name = $keyValue[Schema::CBC .'Name'];
        }

        if (isset($keyValue[Schema::CBC .'Telephone'])) {
            $contact->telephone = $keyValue[Schema::CBC .'Telephone'];
        }

        if (isset($keyValue[Schema::CBC .'Telefax'])) {
            $contact->telefax = $keyValue[Schema::CBC .'Telefax'];
        }

        if (isset($keyValue[Schema::CBC .'ElectronicMail'])) {
            $contact->electronicMail = $keyValue[Schema::CBC .'ElectronicMail'];
        }
        return $contact;
    }
}
