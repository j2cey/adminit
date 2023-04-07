<?php

namespace App\Models\FormattedValue;

use Psy\Util\Json;
use App\Models\BaseModel;
use App\Enums\HtmlTagKey;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;
use App\Traits\FormattedValue\InnerFormattedValue;
use App\Contracts\FormattedValue\IFormattedValueHtml;
use App\Contracts\FormattedValue\IInnerFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FormattedValueHtml
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
 * @property string|Json $applied_style_attributes ['style_key' => "style_value", ...]
 * @property string|Json $applied_weight_tags ['tag_key', ...]
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static FormattedValueHtml create(array $array = null)
 * @method static FormattedValueHtml first()
 */
class FormattedValueHtml extends BaseModel implements IFormattedValueHtml
{
    use HasFactory, InnerFormattedValue;

    protected $table = 'formatted_value_htmls';
    protected $guarded = [];

    protected $casts = [
        'maintag' => HtmlTagKey::class,
    ];

    const MAIN_TAG_LIST = [
        'table' => ['opening' => '<table', 'closing' => '</table>'],
        'table_row' => ['opening' => '<tr', 'closing' => '</tr>'],
        'table_col' => ['opening' => '<td', 'closing' => '</td>'],
    ];
    const SECOND_TAG_LIST = [
        'small' => ['opening' => '<small', 'closing' => '</small>'],
    ];
    const STYLE_ATTRIBUTES_KEY = [
        'size' => "font-size:",
        'color' => "color:",
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

    public static function createNew(array $array = null): FormattedValueHtml {
        return FormattedValueHtml::create([
            'applied_style_attributes' => "[]",
            'applied_weight_tags' => "[]",
            'rawvalue' => "",
            'htmlvalue' => "",
        ]);
    }

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

    public function applyFormat(mixed $value = null, FormatRule $formatrule = null, bool $reset = false) {

        if ( ! is_null($formatrule) ) {
            // set/update applied formats values
            $formattype_text_color = FormatRuleType::textColor()->first();
            $formattype_text_size = FormatRuleType::textSize()->first();
            $formattype_text_weight = FormatRuleType::textWeight()->first();

            if ($formatrule->formatruletype->id === $formattype_text_color->id) {
                $this->setStyleAttribute('color', $formatrule->innerformatrule->getFormatValue());
            } elseif ($formatrule->formatruletype->id === $formattype_text_size->id) {
                $this->setStyleAttribute('size', $formatrule->innerformatrule->getFormatValue());
            } elseif ($formatrule->formatruletype->id === $formattype_text_weight->id) {
                foreach ($formatrule->innerformatrule->getFormatValue() as $tag_key) {
                    $this->setWeightTag($tag_key);
                }
            }
        }

        if ( ! is_null($value)) {
            $this->rawvalue = $value;
        }
        $this->htmlvalue = $this->rawvalue;

        // set inner tags to html value
        $this->setHtmlValueInnerTags();

        // set html value main tag
        $this->htmlvalue = htmlentities(self::MAIN_TAG_LIST[$this->maintag->value]['opening'] . $this->getStyleValues() . '>' . html_entity_decode($this->htmlvalue) . self::MAIN_TAG_LIST[$this->maintag->value]['closing'] );

        $this->save();

        $this->setBody();
    }

    private function setStyleAttribute($style_key, $style_value) {
        $applied_styles = json_decode($this->applied_style_attributes, true);
        $applied_styles[$style_key] = $style_value;

        $this->applied_style_attributes = json_encode($applied_styles);
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

    private function getStyleValues() {
        $applied_styles = json_decode($this->applied_style_attributes, true);
        $stylevalues = '';

        foreach ($applied_styles as $style_key => $style_value) {
            if ( empty($stylevalues) ) {
                $stylevalues = htmlentities(' style="');
            }
            $stylevalues .=  htmlentities(self::STYLE_ATTRIBUTES_KEY[$style_key] . $style_value);
        }
        if ( ! empty($stylevalues) ) {
            $stylevalues .=  htmlentities('"');
        }

        return $stylevalues;
    }

    public function mergeRawValue(IInnerFormattedValue $innerformattedvalue, $value_to_merge) {
        if ($innerformattedvalue instanceof FormattedValueHtml) {
            $this->update([
                'rawvalue' =>$this->rawvalue . trim( html_entity_decode($value_to_merge) ),
            ]);
        }
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

    public function getFormattedValue() {
        return $this->htmlvalue;
    }

    #endregion

}
