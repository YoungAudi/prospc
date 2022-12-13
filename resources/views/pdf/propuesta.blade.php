<!DOCTYPE html>
<html>
<head>
    <title>Propuesta</title>
<style type="text/css">
<!--
* {
    font-family: 'Open Sans', sans-serif;
}
table
{
    width:  100%;
    border: solid 1px #000;
}
table.nb {
    border:  solid 0x #000;
}

td
{
    text-align: center;
    border: solid 0px #113300;
}
td.b {
    border: solid 1px #113300;
}
end_last_page div
{
    border: solid 1mm red;
    height: 27mm;
    margin: 0;
    padding: 0;
    text-align: center;
    font-weight: bold;
}
p {
    padding-bottom: 0px;
    margin-bottom: 0px;
}
td.nb {
    border: solid 0px #113300;
}
td.tar {
    text-align: right;
}
td.text-danger {
    color: red;
}
td.tal {
    text-align: left;
}
-->
</style>
</head>
<body>
    <table style="border: 0px;" class="table nb">
        <colgroup>
            <col style="width: 50%;">
            <col style="width: 50%;">
        </colgroup>
        <tbody>
            <tr>
                <td style="width: 50%;" rowspan="7">LOGO</td>
                <td style="width: 50%;" class="tar"><strong>ATENCIÓN:</strong> {{$prospecto->nombre}}.</td>
            </tr>
            <tr>
                <td class="tar">{{$prospecto->area}}.</td>
            </tr>
            <tr>
                <td class="tar">Lugar: {{$prospecto->estado}}.</td>
            </tr>
            <tr>
                <td class="tar">Fecha de evento: {{date('Y-m-d', strtotime($evento->fecha))}}</td>
            </tr>
            <tr>
                <td class="tar">Fecha de cotización: {{date('Y-m-d', strtotime($propuesta->fecha_cotizacion))}}</td>
            </tr>
            <tr>
                <td class="tar">Valido: {{date('Y-m-d', strtotime($propuesta->fecha_valido))}}</td>
            </tr>
            <tr>
                <td class="text-danger tar">Folio: {{sprintf('%04d', $propuesta->id)}}</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-bottom: 20px;">Propuesta: <strong>{{$propuesta->nombre}}</strong></td>
            </tr>
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <table style="border: 0px;">
                        <tr>
                            <td class="tal" style="width: 100%; padding-bottom: 12px;"><strong>Costo del show:</strong> {{$propuesta->costo}}</td>
                        </tr>
                        <tr>
                            <td class="tal" style="width: 100%;"><strong>Tipo de show:</strong> {{$propuesta->tipo_show}}</td>
                        </tr>
                        <tr>
                            <td class="tal" style="width: 100%; padding-bottom: 12px;"><strong>Duración:</strong> {{$propuesta->duracion}}</td>
                        </tr>
                        <tr>
                            <td class="tal" style="width: 100%;">Necesidades:</td>
                        </tr>
                        @foreach($necesidades as $tipo => $needs)
                        <tr>
                            <td class="tal" style="width: 100%;"><strong>{{$tipo}}:</strong></td>
                        </tr>
                        @foreach($needs as $necesidad)
                        <tr>
                            <td class="tal" style="width: 100%;">- {{$necesidad->nombre}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        @if($propuesta->observaciones != '')
                        <tr>
                            <td class="text-danger tal">*{{$propuesta->observaciones}}</td>
                        </tr>
                        @endif
                    </table>
                </td>
                <td style="width: 40%">
                    <table style="border: 0px; vertical-align: top;">
                        <tr>
                            <td style="width: 90%;"><img src="{{ public_path('storage/'.$talento->imagen) }}" style="width: 100%; height: auto;"></td>
                        </tr>
                        <tr>
                            <td class="tar" style="width: 100%; padding-top: 12px;">Contacto</td>
                        </tr>
                        <tr>
                            <td class="tar" style="width: 100%; padding-top: 0px;">Sergio García.</td>
                        </tr>
                        <tr>
                            <td class="tar" style="width: 100%; padding-top: 0px;">sergio.garcia@enjoymusic.mx</td>
                        </tr>
                        <tr>
                            <td class="tar" style="width: 100%; padding-top: 0px;">Cel. 55 33 21 1799</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="width: 100%; padding-top: 20px">
                <td colspan="2" style="width: 100%;">
                    <table style="border: 0px; vertical-align: middle; width: 100%;">
                        <tr>
                            <td style="width: 33%; padding-top: 20px">
                                <table style="border: 0px; width: 100%;">
                                    <tr>
                                        <td>
                                            <img src="{{ public_path('imgs/envelope-regular.svg') }}" style="width: 32px; height: auto;">
                                        </td>
                                        <td class="tal">
                                            contacto@enjoymusic.mx
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 33%; padding-top: 20px">
                                <table style="border: 0px; width: 100%;">
                                    <tr>
                                        <td>
                                            <img src="{{ public_path('imgs/instagram.svg') }}" style="width: 32px; height: auto;">
                                        </td>
                                        <td class="tal">
                                            enjoymusicmx
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 33%; padding-top: 20px; line-height: 32px;">
                                <table style="border: 0px; width: 100%;">
                                    <tr>
                                        <td>
                                            <img src="{{ public_path('imgs/globe-solid.svg') }}" style="width: 32px; height: auto;">
                                        </td>
                                        <td class="tal">
                                            enjoymusic.mx
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>