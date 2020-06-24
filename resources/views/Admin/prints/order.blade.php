
<script>
    setTimeout(function () {
        window.print();
    }, 1000);

</script>

<title>
    فاکتور فروش
    {{$client->name}}-  {{ $orders->category->name }} - {{ $orders->product->name }}

</title>
<link href="/css/stylefaktor.css" rel="stylesheet">

<table class="table-factor header" style="background: #e9e9e9">
    <tr>
        <td rowspan="3">
            <img src="{{ $setting->images["images"]["original"] }}"/>
        </td>
        <td style="font-size:19px;width: 33%; font-weight: bold"> فاکتور فروش</td>
        <td style="width: 33%;text-align: left;padding-left: 10px">تاریخ سفارش :
            <b><?php $v = new Verta($orders->created_at); echo $v->format('H:i - Y/m/d')  ?></b>

        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: left;padding-left: 10px">تاریخ چاپ :
            <b><?php $v = new Verta(); echo $v->format('H:i - Y/m/d')  ?></b></td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: left;padding-left: 10px">شماره فاکتور :
            <b>{{$orders->order_number}}</b></td>
    </tr>
</table>
<table class="table-factor desc">
    <tr>

        <td rowspan="2"
            style="background: #fcfcfc; color: #000; font-weight: bold;width: 150px">فروشنده</td>
        <td style="text-align: right;padding-right: 10px">
            <b>
            نام شرکت                 :
            </b>  {{$setting->name}}</td>
        <td colspan="3" style="width: 50%">
            <b>
            تلفن :
            </b>  {{$setting->tel}}</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;padding-right: 10px">
            <b>

            آدرس:
            </b>   {{$setting->address}}</td>
    </tr>
</table>
<table class="table-factor desc">
    <tr>
        <td rowspan="2"
            style="background: #fcfcfc; color: #000; font-weight: bold;width: 150px">خریدار</td>
        <td style="text-align: right;padding-right: 10px">
            <b>
                نام:
            </b>
            {{$client->name}}</td>
        <td><b>شرکت                :
            </b>
            {{$client->company}} </td>
        <td>
            <b>
            موبایل :
            </b>   {{$client->mobile}}</td>
        <td> <b>
                تلفن :
            </b>  {{$client->tel}} </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;padding-right: 10px">
            <b>

            آدرس                :
                </b>
            {{$client->address}} </td>
    </tr>
</table>
<table class="table-factor fac">
    <tr class="h" style="font-weight: bold">
        <td>ردیف</td>
        <td>شرح کالا و خدمات</td>
        <td>قیمت پایه</td>
        <td>ابعاد سفارش                            </td>
        <td>تیراژ</td>
        <td>تعداد واحد</td>
        <td>قیمت</td>
    </tr>

    <tr>
        <td>1</td>
        <td style="text-align: right">
         {{ $orders->category->name }} - {{ $orders->product->name }}            </td>
        <td>{{number_format($orderPrice)}}</td>
        <td>

                     {{ ($orders->width) }}
            *
            {{ ($orders->length) }}
        </td>
        <td>{{ number_format($orders->range) }} </td>
        <td>{{ $orders->unit }}</td>
        <td>{{number_format($productPrice - (($orders->range * $allPservicePrice) / 1000) - $orders->price_design )}}</td>
    </tr>
    @if($allPservice)
    <tr>
        <td>2</td>
        <td style="text-align: right">
            {!! $allPservice !!}          </td>
        <td>{{ number_format($allPservicePrice) }}</td>
        <td>
-
        </td>
        <td>{{ number_format($orders->range) }} </td>
        <td></td>
        <td>{{number_format(($orders->range * $allPservicePrice) / 1000 )}}</td>
    </tr>
    @endif

    @if($orders->price_design)
        <tr>
            <td>3</td>
            <td style="text-align: right">
                هزینه طراحی        </td>
            <td>{{ number_format($orders->price_design) }}</td>
            <td>
                -
            </td>
            <td>- </td>
            <td></td>
            <td>{{ number_format($orders->price_design) }}</td>
        </tr>
    @endif



    <tr>
        <td style="font-weight: 600">توضیحات</td>
        <td colspan="6" style="text-align: right; padding-right: 5px;">{{ ($orders->body) }}</td>
    </tr>
    <tr class="h">
        <td rowspan="4">
            <img src="{{$orders->images['front']['100']}}"  width="80" alt="">
        </td>
    </tr>
    <tr class="h">
        <td colspan="5"
            style="text-align: left;padding-left: 10px">تخفیف</td>
        <td>{{number_format($discount)}}</td>
    </tr>
    <tr class="h">
        <td colspan="5"
            style="text-align: left;padding-left: 10px">بیعانه</td>
        <td>{{number_format($deposit)}}</td>
    </tr>
    <tr class="h">
        <td colspan="3"
            style="text-align: right;padding-right: 10px;">
            <b>مبلغ فاکتور به حروف</b>
            : {{$letterPrice}} ریال            </td>
        <td colspan="2"
            style="font-weight: bold;text-align: left;padding-left: 10px;">مبلغ نهایی فاکتور</td>
        <td style="font-weight: bold">{{ number_format($productPrice - $discount - $deposit) }} ریال</td>
    </tr>
    <?php $dpiStatus = false; $quality = false; ?>
    @foreach ($orders->images as $key => $image)
        @if(isset($image['dpi']))
            @if($image['dpi']['x'] < 300 || $image['dpi']['y'] < 300)
                <?php  $dpiStatus = true; ?>
            @endif
            @if($image['dpi']['cmyk'] != 4)
                <?php  $quality = true; ?>
            @endif
        @endif

    @endforeach
    @if($quality == true || $dpiStatus == true)
    <tr>
        <td style="font-weight: 600" colspan="7">

            {!! $quality == true ? '<div class="alert alert-danger" style="color:red; text-align:right; padding-right:5px">  <b>                              فایل شما به صورت آر جی بی ارسال شد و این مجموعه مسئولیتی در قبال تغییر رنگ احتمالی نخواهد داشت .                </b>            </div>' : '' !!}
            {!! $dpiStatus == true ? '<div class="alert alert-danger" style="color:red; text-align:right; padding-right:5px">
             <b>
                    فایل ارسالی شما کیفیت لازم برای چاپ را ندارد ، فایل شما باید 300 دی پی آی باشد و این مجموعه بابت کیفیت چاپ این سفارش مسئولیتی نخواهد داشت .
</b>
                </div>' : '' !!}

        </td>
    </tr>
    @endif
</table>
