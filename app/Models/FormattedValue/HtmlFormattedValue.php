<?php

namespace App\Models\FormattedValue;

use Psy\Util\Json;
use App\Models\BaseModel;
use App\Enums\HtmlTagKey;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\FormattedValue\FormattedValue;
use App\Contracts\FormattedValue\IFormattedValue;
use App\Contracts\FormattedValue\IFormattedValueHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class HtmlFormattedValue
 * @package App\Models\FormattedValue
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string|null $rawvalue
 * @property string|null $htmlvalue
 * @property HtmlTagKey|string|null $maintag
 *
 * @property string|Json $applied_tag_attributes [ 'main_key' => [ 'style_key' => "style_value", ... ], ... ]
 * @property string|Json $applied_weight_tags ['tag_key', ...]
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @method static HtmlFormattedValue first()
 */
class HtmlFormattedValue extends BaseModel implements IFormattedValueHtml
{
    //@method static HtmlFormattedValue create(array $array = null)
    use HasFactory, FormattedValue;

    protected $table = 'html_formatted_values';
    protected $guarded = [];

    protected $casts = [
        'maintag' => HtmlTagKey::class,
    ];

    const MAIN_TAG_LIST = [
        'table' => ['opening' => '<table', 'closing' => '</table>'],
        'table_row' => ['opening' => '<tr', 'closing' => '</tr>'],
        'table_col' => ['opening' => '<td', 'closing' => '</td>'],
        'table_header' => ['opening' => '<th', 'closing' => '</th>'],
    ];
    const SECOND_TAG_LIST = [
        'small' => ['opening' => '<small', 'closing' => '</small>'],
    ];
    const TAG_ATTRIBUTES = [
        'style' => [
            'key' => 'style=',
            'attributes' => [
                'size' => "font-size:",
                'color' => "color:",
                'width' => "width:",
                'border-collapse' => "border-collapse:",
                'border' => "border:",
                'border-spacing' => "border-spacing:",
                ]
            ],
        'role' => [
            'key' => 'role='
        ]
    ];
    const WEIGHT_TAG_LIST = [
        'bold' => ['opening' => '<b', 'closing' => '</b>'],
        'italic' => ['opening' => '<i', 'closing' => '</i>'],
        'underline' => ['opening' => '<u', 'closing' => '</u>'],
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
        ]);
    }

    public static function messagesRules() {
        return [
        ];
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public static function createNew(array $array = null): HtmlFormattedValue {
        return HtmlFormattedValue::create([
            'maintag' => $array['maintag'],
            'applied_tag_attributes' => "[]",
            'applied_weight_tags' => "[]",
            'rawvalue' => $array['rawvalue'] ?? "",
            'htmlvalue' => "",
        ]);
    }

    /**
     * @param mixed|null $value
     * @param Collection|array|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromRaw(mixed $value = null, Collection|array $formatrules = null, bool $reset = false) {
        if ( is_null($value) ) {
            $value = $this->rawvalue;
        }
        $this->applyFormat($value, $formatrules, $reset);
    }

    /**
     * @param mixed|null $value
     * @param Collection|array|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromFormatted(mixed $value = null, Collection|array $formatrules = null, bool $reset = false) {
        if ( is_null($value) ) {
            $value = html_entity_decode($this->htmlvalue);
        }
        $this->applyFormat($value, $formatrules, $reset);
    }

    /**
     * @param mixed|null $value
     * @param Collection|array|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormat(mixed $value = null, Collection|array $formatrules = null, bool $reset = false) {

        if ($reset) {
            //$this->resetRawValue();
            $this->resetHtmlValue();
        }

        if ( $this->maintag === HtmlTagKey::TABLE ) {
            $this->addTableTagDefaultAttributes();
        }

        $this->applied_tag_attributes = $this->applyFormatRulesToAttributes($this->applied_tag_attributes, $formatrules);
        $this->applied_weight_tags = $this->applyFormatRulesToInnerTags($this->applied_weight_tags, $formatrules);

        if ( ! is_null($value)) {
            $this->rawvalue = $value;
        }

        $this->htmlvalue = htmlentities( $this->rawvalue );

        // set inner tags to html value
        $this->htmlvalue = $this->setHtmlValueInnerTags($this->applied_weight_tags, $this->htmlvalue);

        // set html value main tag
        $this->htmlvalue = htmlentities(self::MAIN_TAG_LIST[$this->maintag->value]['opening'] . $this->getAttributesValues($this->applied_tag_attributes) . '>' . html_entity_decode($this->htmlvalue) . self::MAIN_TAG_LIST[$this->maintag->value]['closing'] );

        $this->save();
    }

    public function insertHeadersRow(array $headers, Collection|array $formatrules = null) {
        $headers_col = "";
        foreach ($headers as $header) {
            $applied_tag_attributes = "[]";
            $applied_weight_tags = "[]";

            $applied_tag_attributes = $this->applyFormatRulesToAttributes($applied_tag_attributes, $formatrules);
            $applied_weight_tags = $this->applyFormatRulesToInnerTags($applied_weight_tags, $formatrules);

            $header = $this->setHtmlValueInnerTags($applied_weight_tags, $header);

            $headers_col .= self::MAIN_TAG_LIST['table_header']['opening'] . $this->getAttributesValues($applied_tag_attributes) . '>' . $header . self::MAIN_TAG_LIST['table_header']['closing'];
        }
        $headers_col = self::MAIN_TAG_LIST['table_row']['opening']  . '>' . $headers_col . self::MAIN_TAG_LIST['table_row']['closing'];

        $this->mergeRawValue($this, $headers_col);
    }

    private function addTableTagDefaultAttributes() {
        // role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;"
        $this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'role', "presentation");
        $this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'style', "100%", "width");
        $this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'style', "collapse", "border-collapse");
        $this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'style', 0, "border");
        $this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'style', 0, "border-spacing");
    }

    #region TAG Attributes

    /**
     * Set Tag Attributes to given array
     * @param string $applied_attributes applied attributes array
     * @param string $main_key attribute main key: 'style', 'role', ...
     * @param mixed $style_value attribute value to apply
     * @param string|null $style_key attribute key if main key not directly applied
     * @return false|string
     */
    private function setTagAttributes(string $applied_attributes, string $main_key, mixed $style_value, string $style_key = null)
    {
        // [ 'main_key' => [ 'style_key' => "style_value", ... ], ... ]
        $applied_attributes = json_decode($applied_attributes, true);
        //$applied_attributes = json_decode($this->applied_tag_attributes, true);
        if ( is_null($style_key) ) {
            $applied_attributes[$main_key] = $style_value;
        } else {
            $applied_attributes[$main_key][$style_key] = $style_value;
        }

        //$this->applied_tag_attributes = json_encode($applied_attributes);
        return json_encode($applied_attributes);
    }

    /**
     * Encode and apply attributes
     * @param string $applied_styles
     * @return string
     */
    private function getAttributesValues(string $applied_styles): string
    {
        //$applied_styles = json_decode($this->applied_tag_attributes, true);
        $applied_styles = json_decode($applied_styles, true);
        $output_values = '';

        foreach ($applied_styles as $main_key => $attribute_values_to_applied) {
            $output_values .= ' ';
            $output_values .= self::TAG_ATTRIBUTES[$main_key]['key'];
            if ( array_key_exists('attributes', self::TAG_ATTRIBUTES[$main_key]) ) {
                foreach ($attribute_values_to_applied as $style_key => $style_value) {
                    $output_values .= self::TAG_ATTRIBUTES[$main_key]['attributes'][$style_key] . $style_value . ";";
                }
            } else {
                $output_values .= $attribute_values_to_applied;
            }
        }
        if ( ! empty($output_values) ) {
            $output_values .=  '"';
        }

        return $output_values;
    }

    #endregion

    #region Inner TAGS

    /**
     * @param string $tag_key
     * @param string $applied_tags
     * @return false|string
     */
    private function setWeightTag(string $tag_key, string $applied_tags): bool|string
    {
        //$applied_tags = json_decode($this->applied_weight_tags);
        $applied_tags = json_decode($applied_tags);
        if ( ! in_array($tag_key, $applied_tags) ) {
            $applied_tags[] = $tag_key;
            //$this->applied_weight_tags = json_encode($applied_tags);
        }
        return json_encode($applied_tags);
    }

    /**
     * Apply (and wrap) inner TAGS to a given html value
     * @param string $applied_tags
     * @param string $htmlvalue
     * @return string
     */
    private function setHtmlValueInnerTags(string $applied_tags, string $htmlvalue) {
        //$applied_tags = json_decode($this->applied_weight_tags);
        $applied_tags = json_decode($applied_tags);
        if ( ! empty($applied_tags) ) {
            foreach ($applied_tags as $applied_tag) {
                //$this->htmlvalue = htmlentities(self::WEIGHT_TAG_LIST[$applied_tag]['opening'] . '>' . html_entity_decode($this->htmlvalue) . self::WEIGHT_TAG_LIST[$applied_tag]['closing']);
                $htmlvalue = htmlentities(self::WEIGHT_TAG_LIST[$applied_tag]['opening'] . '>' . html_entity_decode($htmlvalue) . self::WEIGHT_TAG_LIST[$applied_tag]['closing']);
            }
        }
        return $htmlvalue;
    }

    #endregion

    #region Format Rules Application

    /**
     * @param string $applied_tag_attributes
     * @param Collection|array|FormatRule[]|null $formatrules
     * @return false|string
     */
    private function applyFormatRulesToAttributes(string $applied_tag_attributes, Collection|array $formatrules = null) {

        if ( ! is_null($formatrules) ) {
            foreach ($formatrules as $formatrule) {
                if (!is_null($formatrule)) {
                    // set/update applied formats values
                    $formattype_text_color = FormatRuleType::getTextColor();
                    $formattype_text_size = FormatRuleType::getTextSize();

                    if ($formatrule->formatruletype->id === $formattype_text_color->id) {
                        //$this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'style', $formatrule->getRuleValue(),'color');
                        $applied_tag_attributes = $this->setTagAttributes($applied_tag_attributes,'style', $formatrule->getRuleValue(),'color');
                    } elseif ($formatrule->formatruletype->id === $formattype_text_size->id) {
                        //$this->applied_tag_attributes = $this->setTagAttributes($this->applied_tag_attributes,'style', $formatrule->getRuleValue(), 'size');
                        $applied_tag_attributes = $this->setTagAttributes($applied_tag_attributes,'style', $formatrule->getRuleValue(), 'size');
                    }
                }
            }
        }
        return $applied_tag_attributes;
    }

    /**
     * @param string $applied_weight_tags
     * @param Collection|array|FormatRule[]|null $formatrules
     * @return bool|string
     */
    private function applyFormatRulesToInnerTags(string $applied_weight_tags, Collection|array $formatrules = null) {

        if ( ! is_null($formatrules) ) {
            foreach ($formatrules as $formatrule) {
                if (!is_null($formatrule)) {
                    // set/update applied formats values
                    $formattype_text_weight = FormatRuleType::getTextWeight();

                    if ($formatrule->formatruletype->id === $formattype_text_weight->id) {
                        foreach ($formatrule->innerformatrule->getRuleValue() as $tag_key) {
                            //$this->applied_weight_tags = $this->setWeightTag($tag_key, $this->applied_weight_tags);
                            $applied_weight_tags = $this->setWeightTag($tag_key, $applied_weight_tags);
                        }
                    }
                }
            }
        }
        return $applied_weight_tags;
    }

    #endregion

    public function mergeRawValue(IFormattedValue $innerformattedvalue, $value_to_merge) {
        /*if ($innerformattedvalue instanceof HtmlFormattedValue) {
            $this->update([
                'rawvalue' =>$this->rawvalue . trim( html_entity_decode($value_to_merge) ),
            ]);
        }*/
        $this->update([
            'rawvalue' => $this->rawvalue . trim( html_entity_decode($value_to_merge) ),
        ]);
    }

    public function getRawValue() {
        return $this->rawvalue;
    }


    public function setMainTag(HtmlTagKey $tag_key)
    {
        $this->update([
            'maintag' => $tag_key->value
        ]);
    }

    public function resetRawValue() {
        $this->update([
            'rawvalue' => ""
        ]);
    }

    public function resetHtmlValue() {
        $this->update([
            'htmlvalue' => "",
            'applied_tag_attributes' => "[]",
            'applied_weight_tags' => "[]",
        ]);
    }

    public function getFormattedValue(): ?string
    {
        return $this->htmlvalue;
    }

    #endregion

}
