<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <!--[if mso]>
    <noscript>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    </noscript>
    <![endif]-->
    <style>
        table, td, div, h1, p {font-family: Arial, sans-serif;}
    </style>
</head>

<body style="margin:0;padding:0;">
<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
        <td align="center" style="padding:0;">
            <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                <tr>
                    <td align="center" style="padding:20px 0 10px 0;background:#ffffff;">
                        <img src="{{ $message->embed( public_path() . '/images/logo.png' ) }}" alt="" width="100" style="height:auto;display:block;" />
                        <h6 style="font-size:20px;margin:0 0 10px 0;font-family:Arial,sans-serif; color:#C55604">Admin-IT</h6>
                        <p style="margin:0 0 10px 0;font-size:10px;line-height:10px;font-family:Arial,sans-serif; font-style: italic">Let's give us Time to Admin in Time.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 30px 42px 30px;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                                <td style="padding:0 0 36px 0;color:#153643;">
                                    <h6 style="font-size:15px;margin:0 0 10px 0;font-family:Arial,sans-serif;"> {{ $collectedreportfile->reportfile->report->title }} </h6>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0;">

                                    {!! html_entity_decode( $htmlvalue ) !!}

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:5px;background:#FF5733;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                            <tr>
                                <td style="padding:0;width:50%;" align="left">
                                    <p style="margin:0;font-size:8px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        &reg; {{ config('app.name') }} {{ now()->year }} GT/DSI
                                    </p>
                                </td>
                                <td style="padding:0;width:50%;" align="right">
                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                        <tr>
                                            <td style="padding:0 0 0 5px;width:38px;">
                                                <a href="#" style="color:#ffffff;"><img src="{{ $message->embed( public_path() . '/images/facebook.png' ) }}" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                            </td>
                                            <td style="padding:0 0 0 5px;width:38px;">
                                                <a href="#" style="color:#ffffff;"><img src="{{ $message->embed( public_path() . '/images/twiter.png' ) }}" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
