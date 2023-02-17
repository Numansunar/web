<link rel="stylesheet" type="text/css" href="templates/system/odeme/card-master/css/style.css"/>
<script language="javascript" src="templates/system/odeme/card-master/lib/js/jquery.card.js" type="text/javascript"></script>
<style>
    .collapse {
        display: block !important;
        visibility: visible !important;
    }

    .ui-btn-hidden {
        display: none !important;
    }

    
</style>
<img src="images/banka/{%DB_ODEMELOGO%}" alt="" style="margin-bottom:20px;"/>
<div class="cc-odeme-aciklama">{%DB_ODEMEACIKLAMA%}</div>
<div id="pay-screen">
    <div class="demo-wrapper">
        <div class="demo-container">
            <div class="clear-space">&nbsp;</div>
            <div class="card-wrapper"></div>
            <div class="form-container active">
                <div class="row collapse">
                    <div class="cc-taksit">
                        {%TAKSIT%}
                    </div>
                    <div class="small-6 columns" style="width:100%; float:none;">
                        <input name="cardno" autocomplete="off" class="jp-card-invalid mastercard identified" type="text" placeholder="Kart No" vk_1763a="subscribed" id="cardno">
                    </div>
                    <div class="small-6 columns" style="width:100%; float:none;">
                        <input name="kart_isim" type="text" placeholder="Ad Soyad" vk_1763a="subscribed">
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-3 columns">
                        <input name="expmonth" maxlength="2" autocomplete="off" class="exp-update" type="text" placeholder="AY" vk_1763a="subscribed">
                    </div>
                    <div class="small-3 columns">
                        <input name="expyear" maxlength="2" autocomplete="off" class="exp-update" type="text" placeholder="YIL" vk_1763a="subscribed">
                    </div>
                    <div class="small-5 columns">
                        <input name="cv2" autocomplete="off" type="text" placeholder="CVC" vk_1763a="subscribed">
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-12 columns">
                        <input class="button postfix cc-submit-button" type="submit" onclick="$('#cardno').val($('#cardno').val().replace(/ /g,''))" value="Gönder">
                    </div>
                </div>
                <input type="hidden" name="cardtype" id="cardtype">
                <input type="hidden" name="exp" id="exp-update">
            </div>
            <div class="clear-space"></div>
        </div>
        <div class="clear-space"></div>
    </div>
    <div class="clear-space"></div>
</div>
<!-- //pay screen -->
<script type="text/javascript">
    $('.ui-btn-inner').click(function () {
        $('#cardno').val($('#cardno').val().replace(/ /g, ''));
        $('.sp-payment form').submit();
    });
    $('#shopphp-payment-body-step3 form').card({
        // a selector or DOM element for the container
        // where you want the card to appear
        container: '.card-wrapper', // *required*
        formSelectors: {
            numberInput: 'input[name="cardno"]',
            expiryInput: 'input[name="exp"]',
            cvcInput: 'input[name="cv2"]',
            nameInput: 'input[name="kart_isim"]'
        },
        placeholders: {
            number: '&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;',
            cvc: '&bull;&bull;&bull;',
            expiry: '&bull;&bull;/&bull;&bull;',
            name: 'Adı Soyadı'
        },
        messages: {
            validDate: 'Sok Kullanma\nTarihi',
            monthYear: 'ay/yıl'
        }

        // all of the other options from above
    });
    $('.exp-update').keyup(
        function () {
            $('#exp-update').val($('input[name="expmonth"]').val() + '/' + $('input[name="expyear"]').val());
            $('.jp-card-expiry').text($('input[name="expmonth"]').val() + '/' + $('input[name="expyear"]').val()).addClass('jp-card-focused');
        }
    );
    $(function () {
        $('.exp-update').on('keydown', function (e) {
            -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || (/65|67|86|88/.test(e.keyCode) && (e.ctrlKey === true || e.metaKey === true)) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        });
    })

    if ($('.cc-taksit select').length && $('.cc-taksit select').find('option').length == 0) $('.cc-taksit').hide();
</script>