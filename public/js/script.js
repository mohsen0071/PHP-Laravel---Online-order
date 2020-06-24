function getCities(province_id, targetObj, cityId) {
    $.ajax({
        url: '/cities/' + province_id,
        type: 'GET',
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            targetObj
                .attr('disabled', true)
                .find('option:first').attr('selected', 'selected')
                .html('دریافت لیست شهرها');
        },
        complete: function () {

            if(cityId){
                    targetObj
                    .attr('disabled', false)
                  //  .find('option:first').attr('selected', 'selected');
            }else{
                    targetObj
                    .attr('disabled', false)
                    .find('option:first').attr('selected', 'selected');
            }

        },
        error: function (jqXHR) {
            var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
            message(errorText, 'error');
        },
        success: function (data) {
            var options = '<option value="">انتخاب کنید</option>';
            $.each(data, function (k, v) {
                console.log(cityId);
                if(cityId === k)
                {
                    options += '<option value="' + k + '" selected="selected">' + v + '</option>';
                }
                else
                {
                    options += '<option value="' + k + '">' + v + '</option>';
                }

            });
            targetObj.html(options);
        }
    });
}

function threeDigitNumber(input){
    var num=input.value.replace(/[^\d-]/g,'');
    if(num.length>3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    input.value=num;

}

function justNumber(input){
    var num=input.value.replace(/[^\d-]/g,'');
   // if(num.length>3)
    //    num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    input.value=num;

}

function getSheets(categoryId, pos){
    $.ajax({
        url: '/sheets/' + categoryId ,
        type: 'GET',
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            $('.mloading').show();
        },
        complete: function () {
            $('.mloading').hide();

        },
        error: function (jqXHR) {
          //  var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
           // message(errorText, 'error');
        },
        success: function (data) {
            $('.mloading').hide();

            var options = '<option value="">انتخاب کنید</option>';
            console.log(data.length);
            if(data != 0)
            {
                $.each(data, function (k, v) {
                    options += '<option value="' + k + '">'+
                        ' ظرفیت باقیمانده =  '+ v +
                        '</option>';
                });

                if(pos === 'start')
                {
                    $('#startSheet').html('<select class="form-control" onChange="getFile(this.value, '+"'startTable'"+')">'+options+'</select>');
                }
                else
                {
                    $('#endSheet').html('<select class="form-control" onChange="getFile(this.value, '+"'endTable'"+')">'+options+'</select>');
                }

            }else {
                $('#startSheet').html('موردی یافت نشد !');
            }



        }
    });

}

function getFile(SheetId, destination){

    $.ajax({
        url: '/sheets/' + SheetId + '/files' ,
        type: 'GET',
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            $('.mloading').show();
        },
        complete: function () {
            $('.mloading').hide();

        },
        error: function (jqXHR) {
            //  var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
            // message(errorText, 'error');
        },
        success: function (data) {
            $('.mloading').hide();

            var tr = '';
            var  perDate = '';
            $.each(data, function (i) {

                var day = new Date(data[i].created_at);
                var dayWrapper = new persianDate(day);

               var  perDate = dayWrapper.pDate.hours+':'+dayWrapper.pDate.minutes+' - '+dayWrapper.pDate.year+'/'+dayWrapper.pDate.month+'/'+dayWrapper.pDate.day;

                if(data[i].urgent == 1){
                    urgent = '<small class="label label-primary">دارد</small>';
                }else{
                    urgent = '-';
                }
                tr += '<tr><td><input type="checkbox" onchange="viewMoveBtn(this.value)" id="chkfile'+data[i].id+'" name="startFiles" value="'+data[i].id+'"></td><td>'+ (parseInt(i)+1) +'</td><td><img src='+'"'+  (data[i].images['front']['100']) +'"'+' /></td>'+
                    '<td>'+ data[i].client.name +'</td><td>'+ perDate +'</td><td>'+ urgent +'</td><td>'+ data[i].unit +'</td></tr>';
            });
            if(data.length > 0) {
                $('#' + destination).html('<input type="hidden" id="' + destination + 'SheetId" name="' + destination + 'SheetId" value="' + data[0].sheet.id + '"><table class="table table-striped table-bordered table-hover">' +
                    '<tr><td colspan="7"><h3> استفاده شده: <span class="text-danger">' + data[0].sheet.used_unit + '</span>&nbsp;&nbsp;&nbsp;&nbsp;' +
                    '  ظرفیت باقیمانده : ' +
                    '<span class="text-green">' + data[0].sheet.remining_unit + '</span></h3></td></tr>' +
                    '<tr>' +
                    '<td></td>' +
                    '<td>ردیف</td>' +
                    '<td>تصویر</td>' +
                    '<td>نام مشتری</td>' +
                    '<td>تاریخ ثبت</td>' +
                    '<td>فوری</td>' +
                    '<td>تعداد واحد</td>' +
                    '</tr>' + tr + '</table>');
            }else{
                $('#' + destination).html('<input type="hidden" id="' + destination + 'SheetId" name="' + destination + 'SheetId" value="' + SheetId + '">' +
                    '<table class="table table-striped table-bordered table-hover">' +
                    '<td></td>' +
                    '<td>ردیف</td>' +
                    '<td>تصویر</td>' +
                    '<td>نام مشتری</td>' +
                    '<td>تاریخ ثبت</td>' +
                    '<td>فوری</td>' +
                    '<td>تعداد واحد</td>' +
                    '</tr>' + tr + '</table>');
            }
        }
    });
}

function moveSelectedFiles(form){

    var startTableSheetId = $('#startTableSheetId').val();
    var endTableSheetId = $('#endTableSheetId').val();

    if(!endTableSheetId)
    {
        alert('شیت مقصد انتخاب نشده است !');
        return false;
    }

    if(startTableSheetId == endTableSheetId)
    {
        alert('شیت مبدا با شیت مقصد برابر است!');
        return false;
    }

    var selectedFiles = [];
    var startFiles = form.startFiles;

    if(startFiles.length)
    {
        for (var i=0, iLen=startFiles.length; i<iLen; i++) {
            if (startFiles[i].checked) {
                selectedFiles.push(startFiles[i].value);
            }
        }
    }else{
        selectedFiles.push(startFiles.value);
    }


    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/sheets/move' ,
        type: 'POST',
        data: {
            selectedFiles: selectedFiles,
            startTableSheetId: startTableSheetId,
            endTableSheetId: endTableSheetId,
            _token: csrf_token
        },
        cache: false,
        beforeSend: function () {
            $('.mloading').show();
        },
        complete: function () {
            $('.mloading').hide();

        },
        error: function (jqXHR) {
            //  var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
            // message(errorText, 'error');
        },
        success: function (data) {
            $('.mloading').hide();

            if(data == 0)
            {
                alert('تعداد واحد فایل از ظرفیت باقیمانده شیت بیشتر است!');
            }else{
                $('#endTable').html('');
                getFile(endTableSheetId,'startTable');

            }

        }
    });


}

function getChildCategory(categoryId){
    $.ajax({
        url: '/categories/' + categoryId ,
        type: 'GET',
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            $('.mloading').show();
        },
        complete: function () {
            $('.mloading').hide();
        },
        error: function (jqXHR) {
            //  var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
            // message(errorText, 'error');
        },
        success: function (data) {
            $('.mloading').hide();
            $('#childCategory').html('');
            var options = '<option value="">انتخاب کنید</option>';

            $.each(data, function (i) {
                options += '<option value="'+ data[i].id +','+ data[i].sheet_count +'">'
                    + data[i].name +
                    '</option>';
            });

            $('#childCategory').html('<label>سفارش</label><select class="form-control" id="category_id" name="category_id" onChange ="getProduct(this.value)">'+options+'</select>');

        }
    });
}

function getProduct(categoryId){
    result = categoryId.split(',');

    var categoryId = result[0];
    var unit = result[1];
    $('#maxSheetUnit').val(unit);

    $.ajax({
        url: '/products/' + categoryId ,
        type: 'GET',
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            $('.mloading').show();
        },
        complete: function () {
            $('.mloading').hide();
        },
        error: function (jqXHR) {
            //  var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
            // message(errorText, 'error');
        },
        success: function (data) {
            $('.mloading').hide();

            // clear form
            $('#price_design').val('');
            $('#body').val('');
            $('#urgent').html('');
            $('#upfiles').html('');
            $('#pservices').html('');
            $('#customLength').html('');
            $('#bodyProduct').html('');
            $('#price').val('0');
            $('#productUnit').val('0');
            $('#pservicesPrice').val('0');
            $('#pserviceUnit').val('0');
            $('#priceUrgent').val('0');
            $('#minLengthProduct').val('0');
            $('#minWidthProduct').val('0');
            $('#urgentTextPrice').hide();
            $('#range-box').hide();
            $('#design-box').hide();
            $('#body-box').hide();
            $('#insert-box').hide();
            $('#maxLengthProduct').val(0);
            $('#maxWidthProduct').val(0);

            finalCalculate();
            // end clear from

            var options = '<option value="">انتخاب کنید</option>';

            $.each(data, function (i) {
                options += '<option value="' + data[i].id + '">'
                    + data[i].name +
                    '</option>';
            });

            $('#selectProduct').html('<label>محصول</label><select class="form-control" name="product_id" onChange="getDetailProduct(this.value)">'+options+'</select>');

        }
    });
}

function viewMoveBtn(id) {

    var numberOfChecked = $('input:checkbox:checked').length;

    if($('div#startTable #chkfile'+id).is(":checked")){
       $('.movebtn').show();
    }
    else if($('div#startTable #chkfile'+id).is(":not(:checked)")){
        if(numberOfChecked == 0) {
            $('.movebtn').hide();
        }
    }
}

function getDetailProduct(productId){

    var clientId = $('#client_id').val();

    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/product-detail' ,
        type: 'POST',
        cache: false,
        data: {
            productId : productId,
            clientId: clientId,
            _token: csrf_token
        },
        beforeSend: function () {
            $('.mloading').show();
        },
        complete: function () {
            $('.mloading').hide();
        },
        error: function (jqXHR) {
            //  var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
            // message(errorText, 'error');
        },
        success: function (data) {
            $('.mloading').hide();


            // clear form
            $('#price_design').val('');
            $('#body').val('');
            $('#urgent').html('');
            $('#upfiles').html('');
            $('#pservices').html('');
            $('#customLength').html('');
            $('#bodyProduct').html('');
            $('#price').val('0');
            $('#productUnit').val('0');
            $('#pservicesPrice').val('0');
            $('#pserviceUnit').val('0');
            $('#discountAmount').val('0');
            $('#priceUrgent').val('0');
            $('#minLengthProduct').val('0');
            $('#minWidthProduct').val('0');
            $('#urgentTextPrice').hide();
            $('#range-box').hide();
            $('#design-box').hide();
            $('#body-box').hide();
            $('#insert-box').hide();

            $('#maxLengthProduct').val(0);
            $('#maxWidthProduct').val(0);


            finalCalculate();
            // end clear from
            if(data[0].discount > 0){
                $('#discount').show();
                var setDiscount = $('#setDiscount').val();
                if(setDiscount == 1){
                    $('#discountAmount').val(data[0].discount);
                }

            }

            $('#price').val(data[0].price);
            $('#productUnit').val(data[0].unit);
            $('#pserviceUnit').val(data[0].category.pservice_unit);
            $('#minLengthProduct').val(data[0].length);
            $('#minWidthProduct').val(data[0].width);
            $('#lengthText').html(data[0].length);
            $('#widthText').html(data[0].width);
            $('#rangeText').html('1,000');
            $('#unitText').html(data[0].unit);



            $('#range-box').show();
            $('#design-box').show();
            $('#body-box').show();
            $('#insert-box').show();

            var uploadfile = '';
            var datafiles = data[0].allfiles;
            $.each(datafiles, function (i) {
                //uploadfile += '<div class="form-group"><label>'+datafiles[i]+'</label><input type="file" name="'+datafiles[i]+'"></div>';
                var labelfile = '';
                if(datafiles[i] == 'front'){
                    labelfile = 'طرح رو';
                }else if(datafiles[i] == 'back'){
                    labelfile = 'طرح پشت';
                }else if(datafiles[i] == 'uvfront'){
                    labelfile = 'یووی روی طرح';
                }else if(datafiles[i] == 'uvback'){
                    labelfile = 'یووی پشت طرح';
                }else if(datafiles[i] == 'goldfront'){
                    labelfile = 'طلاکوب روی طرح';
                }else if(datafiles[i] == 'goldback'){
                    labelfile = 'طلاکوب پشت طرح';
                }else{

                }

                uploadfile +='<div class="col-lg-6 col-sm-6 col-12 m-b-lg">\
                                        <h4>'+labelfile+'</h4>\
                                    <div class="input-group">\
                                        <label class="input-group">\
                                        <span class="btn btn-primary">\
                                            <input type="file" id="'+datafiles[i]+'" accept=".jpg, .jpeg" onchange="setimage(this)" name="allfiles['+datafiles[i]+']" style="display: none;">\
                                      انتخاب فایل\
                                    </span>\
                                    </label>\
                                    <img id="img'+datafiles[i]+'" src="#"  style="width: 70px; float: right; display:none">\
                                    </div>\
                                    </div>';
                                });

            $('#upfiles').html('<label for="">\
                <p class="text-info">لطفا فقط فایل JPG بارزولیشن dpi 300 را آپلود کنید .</p>\
            </label>'+uploadfile);

            var categoryText = $('.filter-option').text();
            var mainCategoryText = categoryText.replace("--", "");
            $('#titleProduct').html(mainCategoryText+ ' ' + data[0].name);

            if(data[0].body){
                $('#bodyProduct').html('<label>توضیحات محصول</label><div>'+data[0].body+'</div>');
            }

            var field = '';
            if(data[0].length > 0 && data[0].max_length > 0 && data[0].width > 0 && data[0].max_width > 0){

                $('#maxLengthProduct').val(data[0].max_length);
                $('#maxWidthProduct').val(data[0].max_width);

                field = '<label><input type="checkbox" onclick="viewCustomValue()" id="customViewToggle">وارد کردن ابعاد انتخابی</label><div class="hr-line-dashed"></div><div id="box-custom" class="d-none">\
                                <div class="row">\
                                <div class="col-lg-8"><label>طول</label><div class="input-group m-b"><input type="text" name="customInputLength" id="customInputLength" onkeyup="justNumber(this); finalCalculate()" onchange="finalCalculate()" class="form-control">\
                    <span class="input-group-addon"> از '
                    +'<b>'+data[0].length+'</b>'
                    +' تا '
                    +'<b>'+ data[0].max_length+'</b>'
                    +' سانتیمتر</span></div>';

                field += '<label>عرض</label><div class="input-group m-b"><input type="text" name="customInputWidth" id="customInputWidth" onkeyup=" justNumber(this); finalCalculate()"  onchange="finalCalculate()" class="form-control">\
                    <span class="input-group-addon"> از '
                    +'<b>'+data[0].width+'</b>'
                    +' تا '
                    +'<b>'+ data[0].max_width+'</b>'
                    +' سانتیمتر</span></div>'+
                    '</div>\
                    </div>\
                    <div class="hr-line-dashed"></div></div>';


                $('#customLength').html(field);

            }
            else
            {
                $('#customLength').html('');
            }

            var urgent = ''
            if(data[0].urgent_status == 1){
                urgent = '    <div class="col-lg-8" >\
                    <div class="form-group">\
                    <label>\
                    <input type="checkbox" id="selectUrgent" onclick="setPriceUrgent('+"'"+data[0].urgent_price+"'"+')" name="urgent"> <i></i> فوری </label>\
                    </div>\
                    </div>';

                $('#urgent').html(urgent);
            }else{
                $('#urgent').html('');
            }

            var dataPservices = data[0].pservices;


         //   console.log(dataPservices.length);
            if(dataPservices.length > 0){
                var pservices = '';
                $.each(dataPservices, function (i) {

                    pservices += '<div class="form-group" style="float: right; margin-left: 20px">\
                    <label>\
                    <input type="checkbox" id="pservice'+dataPservices[i].id+'" onclick="setPricePservices('+"'"+dataPservices[i].pservice_price+"'"+','+dataPservices[i].id+')" name="pservice_id[]" value="'+dataPservices[i].id+'"> <i></i> '+dataPservices[i].name+' </label>\
                    </div>';
                });

                $('#pservices').html('<div class="row"><div class="col-lg-8" >'+pservices+'</div></div>');
            }else{
                $('#pservices').html('');
            }

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#range-box').show();

            finalCalculate();


        }
    });
}

function viewCustomValue(){

    if($('#customViewToggle').is(":checked")){
        $('#box-custom').show();
    }
    else if($('#customViewToggle').is(":not(:checked)")){
        $('#customInputLength').val('');
        $('#customInputWidth').val('');
        var minLength = parseFloat($('#minLengthProduct').val());
        var minwidth = parseFloat($('#minWidthProduct').val());
        $('#lengthText').html(minLength);
        $('#widthText').html(minwidth);
        $('#box-custom').hide();
    }
}

function setPriceUrgent(priceUrgent){

    if($('#selectUrgent').is(":checked")){
        $('#urgentTextPrice').show();
        $('#priceUrgent').val(priceUrgent);
    }
    else if($('#selectUrgent').is(":not(:checked)")){
        $('#urgentTextPrice').hide();
        $('#priceUrgent').val(0);
    }
    finalCalculate();
}

function setPricePservices(pservicePrice, id){

    var allPservicePrice = $('#pservicesPrice').val();

    if(allPservicePrice == 'NaN' || allPservicePrice == ''){
        allPservicePrice = 0;
    }
    if($('#pservice'+id).is(":checked")){
        $('#pservicesPrice').val(parseInt(allPservicePrice)+parseInt(pservicePrice));
    }
    else if($('#pservice'+id).is(":not(:checked)")){
        $('#pservicesPrice').val(parseInt(allPservicePrice)-parseInt(pservicePrice));
    }
    finalCalculate();
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function finalCalculate(){

    var str = $('#price_design').val();

    if(str.length > 0){
        var priceDesign = str.replace(",", "");
    }else{
        var priceDesign = 0;
    }



    var range = $('#myRange').val() / 1000;


    $('#unitText').html($('#productUnit').val());
    var price = $('#price').val();
    var pservicesPrice = $('#pservicesPrice').val();
    var pserviceUnit = $('#pserviceUnit').val();
    var productUnit = 1;
    var priceUrgent = $('#priceUrgent').val();


    var customInputLength = parseFloat($('#customInputLength').val());
    var customInputWidth = parseFloat($('#customInputWidth').val());
    var minLength = parseFloat($('#minLengthProduct').val());
    var minwidth = parseFloat($('#minWidthProduct').val());

    if((customInputLength) && (customInputWidth)){
        var widthOne  =Math.ceil((customInputWidth/minwidth));
        var lengthOne =Math.ceil((customInputLength/minLength));
        var widthTwo=Math.ceil((customInputLength/minwidth));
        var lengthTwo=Math.ceil((customInputWidth/minLength));
        var oneResult = widthOne * lengthOne;
        var twoResult = widthTwo * lengthTwo;
        if(oneResult<twoResult){
            productUnit=oneResult
        }else{
            productUnit=twoResult
        }
        $('#lengthText').html(customInputLength);
        $('#widthText').html(customInputWidth);

    }else if(customInputLength){
        var widthOne  =Math.ceil((minwidth/minwidth));
        var lengthOne =Math.ceil((customInputLength/minLength));
        var widthTwo=Math.ceil((customInputLength/minwidth));
        var lengthTwo=Math.ceil((minwidth/minLength));
        var oneResult = widthOne * lengthOne;
        var twoResult = widthTwo * lengthTwo;
        if(oneResult<twoResult){
            productUnit=oneResult
        }else{
            productUnit=twoResult
        }
        $('#lengthText').html(customInputLength);
        $('#widthText').html(minwidth);

    }else if(customInputWidth){
        var widthOne  =Math.ceil((customInputWidth/minwidth));
        var lengthOne =Math.ceil((minLength/minLength));
        var widthTwo=Math.ceil((minLength/minwidth));
        var lengthTwo=Math.ceil((customInputWidth/minLength));
        var oneResult = widthOne * lengthOne;
        var twoResult = widthTwo * lengthTwo;
        if(oneResult<twoResult){
            productUnit=oneResult
        }else{
            productUnit=twoResult
        }
        $('#lengthText').html(minLength);
        $('#widthText').html(customInputWidth);
    }else{
        $('#lengthText').html(minLength);
        $('#widthText').html(minwidth);
    }

    $('#productUnit').val(productUnit);

    if(priceUrgent > 0){
        price = priceUrgent;
    }

    $('#rangeText').html(numberWithCommas($('#myRange').val()));

    var finalPrice = 0;

    if(pservicesPrice > 0){
        $('#pservicePriceText').html(numberWithCommas( parseInt(range) * (parseInt(pservicesPrice) * parseInt(pserviceUnit))));
    }else{
        $('#pservicePriceText').html(0);
    }

    var discountAmount = $('#discountAmount').val();


    finalPrice = (parseInt(range) * parseInt(pservicesPrice) * parseInt(pserviceUnit)) + (parseInt(productUnit) * (parseInt(range) * (parseInt(price)))) + parseInt(priceDesign);

    var discount = (finalPrice * discountAmount) / 100;

    $('#priceDesign').html(numberWithCommas(priceDesign));
    $('#orderPrice').html(numberWithCommas(parseInt(productUnit) * parseInt(range) * parseInt(price)));
    $('#finalPrice').html(numberWithCommas(finalPrice - discount));
    $('.discountPrice').text(numberWithCommas(discount));
}

function submitFrom(){

    var categoryId = $('#category_id').val();
    if(categoryId == null || categoryId==""){
        alert('لطفا  سفارش را انتخاب کنید !'); return false;
    }

    var orderTitle = $('#orderTitle').val();
    if(orderTitle.length == 0){
        alert('عنوان سفارش را وارد کنید')
        return false;
    }
    var myRange = $('#myRange').val();
    if(myRange.length == 0){
        alert('تیراژ را وارد کنید')
        return false;
    }

    checkfileup = false;

    $("#upfiles").find("input[type=file]").each(function(index, field){

        const file = field.files[0];

        if(!file){
            checkfileup = false;
            alert('فایل  ها را انتخاب کنید');
            return false;
        }else{

            checkfileup = true;
        }

        if(file.type != "image/jpeg"){
            checkfileup = false;
            alert('فایل های انتخابی شما jpg نیست !');
            return false;
        }else{
            checkfileup = true;
        }


    });

    var customInputLength = $('#customInputLength').val();
    var customInputWidth = $('#customInputWidth').val();
    var maxLengthProduct = $('#maxLengthProduct').val();
    var maxWidthProduct = $('#maxWidthProduct').val();


    if(customInputLength && customInputLength.length > 0){
        if(parseFloat(customInputLength) > parseFloat(maxLengthProduct)){
            alert(' حداکثر طول ابعاد انتخابی '+ maxLengthProduct +' می باشد. ' + 'شما مقدار' + customInputLength + 'را وارد کرده اید.');
            return false;
        }
    }

    if(customInputWidth && customInputWidth.length > 0){
        if(parseFloat(customInputWidth) > parseFloat(maxWidthProduct)){
            alert(' حداکثر عرض ابعاد انتخابی '+ maxWidthProduct +' می باشد. ' + 'شما مقدار' + customInputWidth + 'را وارد کرده اید.');
            return false;
        }
    }

    var maxSheetUnit = $('#maxSheetUnit').val();
    var productUnit = $('#productUnit').val();
    var myRange = $('#myRange').val() / 1000;
    if(parseFloat(productUnit) * parseFloat(myRange) > parseFloat(maxSheetUnit)){
        alert('تیراژ انتخابی از ظرفیت فرم بیشتر است');
        return false;
    }



    if(checkfileup){
        $('#orderform').submit();
    }
}