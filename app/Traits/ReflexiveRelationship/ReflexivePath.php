<?php


namespace App\Traits\ReflexiveRelationship;

use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Types\Integer;

trait ReflexivePath
{
    abstract public static function getReflexiveParentIdField(): string;
    abstract public static function getTitleField(): string;
    abstract public static function getReflexiveFullPathField(): string;
    abstract public static function getReflexivePathSeparator(): string;

    /**
     * Get model full path
     * @param $title
     * @param $parent_id
     * @return string
     */
    public static function getFullPath($title, $parent_id) {
        if (is_null($parent_id)) {
            return $title;
        } else {
            $elem_type = get_called_class();
            $parent = $elem_type::find($parent_id);

            return $parent->{$elem_type::getReflexiveFullPathField()} . $elem_type::getReflexivePathSeparator() . $title;
        }
    }

    private function rebuildFullPath() {
        $elem_type = get_called_class();
        $new_full_path = $elem_type::getFullPath($this->{$this->getTitleField()}, $this->{$this->getReflexiveParentIdField()});
        if ($this->{$this->getReflexiveFullPathField()} == $new_full_path) {
            // nothing to do
        } else {
            // we set the new one
            $this->{$this->getReflexiveFullPathField()} = $new_full_path;
            $this->save();
        }
    }
}
