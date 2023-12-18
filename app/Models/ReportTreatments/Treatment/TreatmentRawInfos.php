<?php

namespace App\Models\ReportTreatments\Treatment;

use App\Models\ReportTreatments\Treatment;

trait TreatmentRawInfos
{
    #region Raw infos management
    public function setName(string $name): static
    {
        /*
        $this->name = $name;
        $this->save();
        */
        $this->update([
            'name' => $name
        ]);

        return $this;
    }
    /*public function setNumOrd(): static
    {
        $subs_count = $this->subtreatments()->count();
        $this->num_ord = $subs_count + 1;

        $this->save();

        return $this;
    }*/

    public function setIsLastSubtreatment(bool $value, Treatment|null $uppertreatment): static
    {
        $this->update([
            'is_last_subtreatment' => $value
        ]);

        $uppertreatment?->setChildIsLastSubUpdated($this);

        return $this;
    }
    public function setChildIsLastSubUpdated(Treatment $child_treatment): static
    {
        $this->update([
            'all_subtreatments_launched' => $child_treatment->is_last_subtreatment
        ]);

        return $this;
    }
    public function setCanEndUpperTreatment(bool $value): static
    {
        $this->update([
            'can_end_uppertreatment' => $value
        ]);

        return $this;
    }
    #endregion
}
