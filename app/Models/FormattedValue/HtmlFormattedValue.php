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

    /*public static function create(array $attributes = [])
    {
        // Your custom code goes here
        $attributes['applied_tag_attributes'] = "[]";
        $attributes['applied_weight_tags'] = "[]";
        $attributes['rawvalue'] = "";
        $attributes['htmlvalue'] = "";

        return parent::create($attributes);
    }*/

    public function setHeader($value = null) {
        $open_main_tag = htmlentities('<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">');
        $default_header = $open_main_tag . htmlentities('<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="x-apple-disable-message-reformatting"><title></title><!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]--><style>table, td, div, h1, p {font-family: Arial, sans-serif;}</style></head>');

        $this->formattedvalue->header = "";
        $this->formattedvalue->save();
    }
    public function setBody($value = null) {
        $defauly_body = htmlentities('<body style="margin:0;padding:0;">');
        $defauly_body .= htmlentities('<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">');
        $defauly_body .= htmlentities('<tr><td align="center" style="padding:0;"><table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;"><tr><td align="center" style="padding:40px 0 30px 0;background:#ffffff;"><img src="{{ $message->embed( public_path() . \'/images/logo.png\' ) }}" alt="" width="100" style="height:auto;display:block;" /><h6 style="font-size:20px;margin:0 0 10px 0;font-family:Arial,sans-serif; color:#C55604">Admin-IT</h6><p style="margin:0 0 10px 0;font-size:10px;line-height:10px;font-family:Arial,sans-serif; font-style: italic">Let\'s give us Time to Admin in Time.</p></td></tr>');
        $defauly_body .= htmlentities('<tr><td style="padding:36px 30px 42px 30px;"><table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;"><tr><td style="padding:0 0 36px 0;color:#153643;"><h6 style="font-size:15px;margin:0 0 10px 0;font-family:Arial,sans-serif;">Alert Rapport: </h6></td></tr><tr><td style="padding:0;"><table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;"><tr>');
        $defauly_body .= htmlentities('<td style="width:260px;padding:0;vertical-align:top;color:#153643;">');
        $defauly_body .= htmlentities('<p style="margin:0 0 12px 0;font-size:10px;line-height:20px;font-family:Arial,sans-serif;">');
        $defauly_body .= htmlentities('<dl>');
        $defauly_body .= htmlentities('<dt><small> <strong>Label 1:</strong> </small></dt>');
        $defauly_body .= htmlentities('<dd> <small>value 1</small></dd>');
        $defauly_body .= htmlentities('<dt><small> <strong>Label 2:</strong> </small></dt>');
        $defauly_body .= htmlentities('<dd><small>value 2</small></dd>');
        $defauly_body .= htmlentities('<dt><small> <strong>Label 3:</strong> </small></dt>');
        $defauly_body .= htmlentities('<dd><small>value 3</small></dd>');
        $defauly_body .= htmlentities('<dt><small> <strong>Label 4:</strong> </small></dt>');
        $defauly_body .= htmlentities('<dd><small>value 4</small></dd>');
        $defauly_body .= htmlentities('<dt><small> <strong>Label 5:</strong> </small></dt>');
        $defauly_body .= htmlentities('<dd><small>value 5</small></dd>');
        $defauly_body .= htmlentities('</dl>');
        $defauly_body .= htmlentities('</p>');
        $defauly_body .= htmlentities('</td>');
        $defauly_body .= htmlentities('</tr></table></td></tr></table></td></tr>');

        $defauly_body .= htmlentities('<tr><td style="padding:5px;background:#FF5733;">');
        $defauly_body .= htmlentities('<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">');
        $defauly_body .= htmlentities('<tr>');
        $defauly_body .= htmlentities('<td style="padding:0;width:50%;" align="left"><p style="margin:0;font-size:8px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">&reg; {{ config(\'app.name\') }} {{ now()->year }} GT/DSI</p></td>');
        $defauly_body .= htmlentities('<td style="padding:0;width:50%;" align="right">');
        $defauly_body .= htmlentities('<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">');
        $defauly_body .= htmlentities('<tr><td style="padding:0 0 0 5px;width:38px;"><a href="#" style="color:#ffffff;"><img src="{{ $message->embed( public_path() . \'/images/facebook.png\' ) }}" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a></td><td style="padding:0 0 0 5px;width:38px;">');
        $defauly_body .= htmlentities('<a href="#" style="color:#ffffff;"><img src="{{ $message->embed( public_path() . \'/images/twiter.png\' ) }}" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a></td></tr></table></td></tr></table></td></tr>');

        $defauly_body .= htmlentities('</table></td></tr></table></body>');

        //$this->formattedvalue->body = $defauly_body;
        //$this->formattedvalue->save();


        $inner_body = htmlentities('<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">');
        $inner_body .= htmlentities('<tr>');
        $inner_body .= htmlentities('<td style="width:260px;padding:0;vertical-align:top;color:#153643;">');
        $inner_body .= htmlentities('<p style="margin:0 0 12px 0;font-size:10px;line-height:20px;font-family:Arial,sans-serif;">');
        $inner_body .= htmlentities('<dl>');
        $inner_body .= htmlentities('<dt><small> <strong>Label 1:</strong> </small></dt>');
        $inner_body .= htmlentities('<dd> <small>value 1</small></dd>');
        $inner_body .= htmlentities('<dt><small> <strong>Label 2:</strong> </small></dt>');
        $inner_body .= htmlentities('<dd><small>value 2</small></dd>');
        $inner_body .= htmlentities('<dt><small> <strong>Label 3:</strong> </small></dt>');
        $inner_body .= htmlentities('<dd><small>value 3</small></dd>');
        $inner_body .= htmlentities('<dt><small> <strong>Label 4:</strong> </small></dt>');
        $inner_body .= htmlentities('<dd><small>value 4</small></dd>');
        $inner_body .= htmlentities('<dt><small> <strong>Label 5:</strong> </small></dt>');
        $inner_body .= htmlentities('<dd><small>value 5</small></dd>');
        $inner_body .= htmlentities('</dl>');
        $inner_body .= htmlentities('</p>');
        $inner_body .= htmlentities('</td>');
        $inner_body .= htmlentities('</tr>');
        $inner_body .= htmlentities('</table>');

        $this->formattedvalue->body = $inner_body;
        $this->formattedvalue->save();
    }
    public function setFooter($value = null) {
        $closing_main_tag = htmlentities('</html>');

        $this->formattedvalue->footer = "";
        $this->formattedvalue->save();
    }

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromRaw(mixed $value = null, Collection $formatrules = null, bool $reset = false) {
        if ( is_null($value) ) {
            $value = $this->rawvalue;
        }
        $this->applyFormat($value, $formatrules, $reset);
    }

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromFormatted(mixed $value = null, Collection $formatrules = null, bool $reset = false) {
        if ( is_null($value) ) {
            $value = html_entity_decode($this->htmlvalue);
        }
        $this->applyFormat($value, $formatrules, $reset);
    }

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormat(mixed $value = null, Collection $formatrules = null, bool $reset = false) {

        if ( $this->maintag === HtmlTagKey::TABLE ) {
            $this->addTableTagDefaultAttributes();
        }

        $this->applyFormatRules($formatrules);

        if ( ! is_null($value)) {
            $this->rawvalue = $value;
        }

        $this->htmlvalue = htmlentities( $this->rawvalue );

        // set inner tags to html value
        $this->setHtmlValueInnerTags();

        // set html value main tag
        $this->htmlvalue = htmlentities(self::MAIN_TAG_LIST[$this->maintag->value]['opening'] . $this->getAttributesValues() . '>' . html_entity_decode($this->htmlvalue) . self::MAIN_TAG_LIST[$this->maintag->value]['closing'] );

        $this->save();
    }

    public function insertHeadersRow(array $headers) {
        $headers_col = "";
        foreach ($headers as $header) {
            $headers_col .= self::MAIN_TAG_LIST['table_header']['opening']  . '>' . $header . self::MAIN_TAG_LIST['table_header']['closing'];
        }
        $headers_col = self::MAIN_TAG_LIST['table_row']['opening']  . '>' . $headers_col . self::MAIN_TAG_LIST['table_row']['closing'];

        $this->mergeRawValue($this, $headers_col);
    }

    /**
     * @param Collection|FormatRule[]|null $formatrules
     * @return void
     */
    private function applyFormatRules(Collection $formatrules = null) {

        if ( ! is_null($formatrules) ) {
            foreach ($formatrules as $formatrule) {
                if (!is_null($formatrule)) {
                    // set/update applied formats values
                    $formattype_text_color = FormatRuleType::textColor()->first();
                    $formattype_text_size = FormatRuleType::textSize()->first();
                    $formattype_text_weight = FormatRuleType::textWeight()->first();

                    if ($formatrule->formatruletype->id === $formattype_text_color->id) {
                        $this->setTagAttributes('style', $formatrule->getRuleValue(),'color');
                    } elseif ($formatrule->formatruletype->id === $formattype_text_size->id) {
                        $this->setTagAttributes('style', $formatrule->getRuleValue(), 'size');
                    } elseif ($formatrule->formatruletype->id === $formattype_text_weight->id) {
                        foreach ($formatrule->innerformatrule->getRuleValue() as $tag_key) {
                            $this->setWeightTag($tag_key);
                        }
                    }
                }
            }
        }
    }

    private function addTableTagDefaultAttributes() {
        // role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;"
        $this->setTagAttributes('role', "presentation");
        $this->setTagAttributes('style', "100%", "width");
        $this->setTagAttributes('style', "collapse", "border-collapse");
        $this->setTagAttributes('style', 0, "border");
        $this->setTagAttributes('style', 0, "border-spacing");
    }

    private function setTagAttributes($main_key, $style_value, $style_key = null) {
        // [ 'main_key' => [ 'style_key' => "style_value", ... ], ... ]
        $applied_attributes = json_decode($this->applied_tag_attributes, true);
        if ( is_null($style_key) ) {
            $applied_attributes[$main_key] = $style_value;
        } else {
            $applied_attributes[$main_key][$style_key] = $style_value;
        }

        $this->applied_tag_attributes = json_encode($applied_attributes);
    }
    private function setWeightTag($tag_key) {
        $applied_tags = json_decode($this->applied_weight_tags);
        if ( ! in_array($tag_key, $applied_tags) ) {
            $applied_tags[] = $tag_key;
            $this->applied_weight_tags = json_encode($applied_tags);
        }
    }

    private function setHtmlValueInnerTags() {
        $applied_tags = json_decode($this->applied_weight_tags);
        if ( ! empty($applied_tags) ) {
            foreach ($applied_tags as $applied_tag) {
                $this->htmlvalue = htmlentities(self::WEIGHT_TAG_LIST[$applied_tag]['opening'] . '>' . html_entity_decode($this->htmlvalue) . self::WEIGHT_TAG_LIST[$applied_tag]['closing']);
            }
        }
    }

    private function getAttributesValues() {
        $applied_styles = json_decode($this->applied_tag_attributes, true);
        $output_values = '';

        /*
             const TAG_ATTRIBUTES = [
            'style' => [
                'key' => 'style=',
                'attributes' => [
                    'size' => "font-size:",
                    'color' => "color:",
                    ]
                ],
            'role' => [
                'key' => 'role='
                ]
             ];
         */

        // [ 'main_key' => [ 'style_key' => "style_value", ... ], ... ]
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
            /*if ( empty($attributes_values) ) {
                $attributes_values = ' style="';
            }
            $attributes_values .=  self::TAG_ATTRIBUTES[$main_key] . $style_value;*/
        }
        if ( ! empty($output_values) ) {
            $output_values .=  '"';
        }

        return $output_values;
    }

    public function mergeRawValue(IFormattedValue $innerformattedvalue, $value_to_merge) {
        /*if ($innerformattedvalue instanceof HtmlFormattedValue) {
            $this->update([
                'rawvalue' =>$this->rawvalue . trim( html_entity_decode($value_to_merge) ),
            ]);
        }*/
        $this->update([
            'rawvalue' =>$this->rawvalue . trim( html_entity_decode($value_to_merge) ),
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

    public function getFormattedValue(): ?string
    {
        return $this->htmlvalue;
    }

    #endregion

}
