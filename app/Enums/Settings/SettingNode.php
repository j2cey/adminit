<?php

namespace App\Enums\Settings;

use Hamcrest\Core\Set;
use App\Models\Setting;

/**
 * Class SettingNode. Node setting structure
 * @package App\Enums\Settings
 *
 */
class SettingNode
{
    private string $_array_sep_default = ",";
    private string $_node_sep_default = ".";

    private string $_name;
    private ?SettingNode $_parent = null;
    private mixed $_value = null;
    private ?string $_type = null;
    private string $_array_sep;
    private string $_description;
    private array $_children = [];

    public function __construct(string $name, mixed $value = null, string $type = null, SettingNode $parent = null, string $array_sep = null, string $description = "")
    {
        $this->setName($name);
        if ( ! is_null($value) ) {
            $this->setValue($value);
        }
        if ( ! is_null($type) ) {
            $this->setType($type);
        }

        $this->setArraySep(is_null($array_sep) ? $this->_array_sep_default : $array_sep);
        $this->setDescription($description);

        if ( ! is_null($parent) ) {
            $this->setParent($parent);
        }
    }

    public function __call($name, $args)
    {
        // Return called child if exists
        return $this->getChild($name);
    }

    /**
     * Get default value (from hard object)
     * @return mixed
     */
    public function getDefault(): mixed {
        return $this->getParsedValue();
    }

    /**
     * Get live value (from DB)
     * @return mixed
     */
    public function get(): mixed {
        return $this->getFromDB()?->typed_value;
    }

    /**
     * Get the Full Path of this setting node
     * @return string
     */
    public function getFullPath(): string {
        //dump("node " . $this->getName() . " getFullPath");
        if ( is_null($this->getParent()) ) {
            return $this->getName();
        }
        return $this->getParent()->getFullPath() . $this->_node_sep_default . $this->getName();
    }

    /**
     * @param string $name
     * @param mixed|null $value
     * @param string|null $type
     * @param string $description
     * @param string|null $array_sep
     * @return SettingNode|null
     */
    public function addChild(string $name, mixed $value = null, string $type = null, string $description = "", string $array_sep = null): ?SettingNode {
        if ( is_null($this->getChild($name)) ) {

            $node = new SettingNode($name,$value,$type,$this,$array_sep,$description);

            $children = $this->getChildren();
            $children[] = $node;
            $this->setChildren($children);
            return $node;
        }
        return null;
    }

    public function addArchiveChildren(ArchiveState $state, ArchiveUnit $unit, string $value): static
    {
        $this->addChild("state", $state->value, "string", $this->getNameNormalized() . " state");
        $this->addChild("unit", $unit->value, "string", $this->getNameNormalized() . " unit.");
        $this->addChild("value", $value, "integer", $this->getNameNormalized() . " value.");

        return $this;
    }

    /**
     * @param string $name
     * @return SettingNode|null
     */
    public function getChild(string $name): ?SettingNode
    {
        $children = $this->getChildren();
        foreach ($children as $child) {
            if ($child->getName() == $name) return $child;
        }
        return null;
    }

    /**
     * Save setting node to DB
     * @return void
     */
    public function save() {
        Setting::createNew($this->getName(), $this->getParentFromDB(), $this->getValue(), $this->getType(), $this->getArraySep(), $this->getDescription());
    }

    public function saveChildren() {
        if ( empty($this->getChildren()) ) {
            return;
        }
        foreach ($this->getChildren() as $child) {
            $child->save();
            $child->saveChildren();
        }
    }

    /**
     * @return Setting|null
     */
    private function getFromDB(): ?Setting {
        return Setting::getByFullPath($this->getFullPath());
    }

    /**
     * @return Setting|null
     */
    private function getParentFromDB(): ?Setting {
        return is_null($this->getParent()) ? null : Setting::getByFullPath($this->getParent()->getFullPath());
    }

    private function getParsedValue(): mixed {
        return Setting::getParsedValue(['type' => $this->getType(), 'value' => $this->getValue()]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getNameNormalized(): string
    {
        return $this->camelCase2UnderScore($this->_name, " ");
    }

    private function camelCase2UnderScore($str, $separator = "_")
    {
        if (empty($str)) {
            return $str;
        }
        $str = lcfirst($str);
        $str = preg_replace("/[A-Z]/", $separator . "$0", $str);
        return strtolower($str);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @return SettingNode|null
     */
    public function getParent(): ?SettingNode
    {
        return $this->_parent;
    }

    /**
     * @param SettingNode $parent
     */
    public function setParent(SettingNode $parent): void
    {
        $this->_parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue(mixed $value): void
    {
        $this->_value = $value;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->_type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->_type = $type;
    }

    /**
     * @return string
     */
    public function getArraySep(): string
    {
        return $this->_array_sep;
    }

    /**
     * @param string $array_sep
     */
    public function setArraySep(string $array_sep): void
    {
        $this->_array_sep = $array_sep;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->_description = $description;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->_children;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children): void
    {
        $this->_children = $children;
    }
}
