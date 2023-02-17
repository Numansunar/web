// JavaScript Document
var lastSSSID = 0;
var lastTabID = "";
var selectedPayType = 0;
var lastFocusedId = "";
var urunSepeteEkleAdet = 1;
var secimURL = "";
var secimURLAppend = "";
var pushAlert = "";
var sepetEkleKontrolValue = true;
var stopSubmit = false;
var msc = 1;
var isMobile = 0;
var RecaptchaOptions = { theme: "clean" };
var totalTopMenuItems = 0;
var shopPHPUrunID = 0;
var shopPHPUrunID = 0;
var shopPHPUrunFiyatOrg = 0;
var shopPHPUrunFiyatT = 0;
var shopPHPUrunFiyatYTL = 0;
var shopPHPTekCekimOran = 0;
var shopPHPHavaleIndirim = 0;
var shopPHPFiyatCarpan = 0;
var shopPHPFiyatCarpanT = 0;
var shopPHPUrunKDV = 0;
var siteDizini = "";
var paytrURL = "";
var alerter;
var kurusgizle = 0;
var adetArray = Array();

if (
  typeof jQuery.fn.live == "undefined" ||
  !jQuery.isFunction(jQuery.fn.live)
) {
  jQuery.fn.extend({
    live: function (event, callback) {
      if (this.selector) {
        jQuery(document).on(event, this.selector, callback);
      }
    },
  });
}

jQuery.fn.anchorAnimate = function (settings) {
  settings = jQuery.extend(
    {
      speed: 1000,
    },
    settings
  );

  return this.each(function () {
    var caller = this;
    $(caller).click(function (event) {
      event.preventDefault();
      var locationHref = window.location.href;
      var elementClick = $(caller).attr("href");
      var destination = $(elementClick).offset().top - 135;
      $("html:not(:animated),body:not(:animated)").animate(
        { scrollTop: destination },
        settings.speed,
        function () {
          //window.location.hash = elementClick
        }
      );
      return false;
    });
  });
};

function tabLoad(obj, filter, urunList, urunListShow) {
  if (!$(obj).find(".clear-space").length) {
    $(obj).html(ajaxLoaderDiv());
    url =
      "include/ajaxLib.php?act=tabLoad&filter=" +
      filter +
      "&urunList=" +
      urunList +
      "&urunListShow=" +
      urunListShow +
      "&isAjax=1";
    $.get(url, function (data) {
      $(obj).html(data + '<div class="clear-space"></div>');
      $(".piyasa-indirim").each(function () {
        if ($(this).text() == "%" || !$(this).text()) $(this).remove();
      });
    });
  }
}

function ajaxLoaderDiv() {
  return '<div class="SPajaxLoader"><img src="images/ajax-loader.gif" /></div>';
}

function sepetAdetGuncelle(lineID, adet) {
  // $('.basket-wrap:first').html(ajaxLoaderDiv());
  url =
    "page.php?act=sepet&op=guncelle&lineID=" +
    lineID +
    "&adet=" +
    adet +
    "&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
}

function sepetSecimGuncelle(paytype, taksit) {
  // return;
  // $('.basket-wrap:first').html(ajaxLoaderDiv());
  url =
    "page.php?act=sepet&paytype=" +
    paytype +
    "&taksit=" +
    taksit +
    "&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
}

function sepetSatirSil(lineID, urunID) {
  // $('.basket-wrap:first').html(ajaxLoaderDiv());
  url =
    "page.php?act=sepet&op=sil&lineID=" +
    lineID +
    "&urunID=" +
    urunID +
    "&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
}

function sepetBosalt() {
  // $('.basket-wrap:first').html(ajaxLoaderDiv());
  url = "page.php?act=sepet&op=bosalt&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
}

function sepetHTMLGuncelle(dataHTML) {
  if ($(dataHTML).find(".basket-wrap:first").html() != null)
    $(".basket-wrap:first").html($(dataHTML).find(".basket-wrap:first").html());
  var url = "include/ajaxLib.php?act=sepetGoster";
  $.get(url, function (data) {
    updateSepetBilgi("#toplamFiyat", "ModulFarkiIle");
    updateSepetBilgi("#toplamUrun", "toplamUrun");

    $("#sepetGoster .basket-wrap").html($(data).find(".basket-wrap").html());
    if ($(dataHTML).find(".basket-wrap:first").html() == null) {
      $(".basket-wrap:first").html($(data).find(".basket-wrap:first").html());
    }
  });
}

function sepetAdresHTMLGuncelle() {
  var url = "page.php?act=satinal&op=adres";
  $.get(url, function (data) {
    $(".basket-wrap").html($(data).find(".basket-wrap").html());
  });
}

function goUrun(urunID) {
  if (!urunID) return;
  url = "include/ajaxLib.php?act=getUrunLink&urunID=" + urunID;
  $.get(url, function (data) {
    window.location.href = data;
  });
}

function goCat(catID) {
  if (!catID) return;
  url = "include/ajaxLib.php?act=getCategoryLink&catID=" + catID;
  $.get(url, function (data) {
    window.location.href = data;
  });
}

function urunListAjax(id, catID, order, limit, urunlist, urunlistshow) {
  url =
    "include/ajaxLib.php?act=urunList&catID=" +
    catID +
    "&orderBy=" +
    encodeURIComponent(order) +
    "&limit=" +
    limit +
    "&urunlist=" +
    encodeURIComponent(urunlist) +
    "&urunlistshow=" +
    encodeURIComponent(urunlistshow);
  $.get(url, function (data) {
    $("#" + id).html(data);
  });
}

function kategoriListAjax(id, parentID) {
  url = "include/ajaxLib.php?act=kategoriListOption&parentID=" + parentID;
  $.get(url, function (data) {
    $("#" + id).html(data);
  });
}

function shopPHPPaymentStep2(formID) {
  if (typeof myShopPHPPaymentStep2 == "function") {
    return myShopPHPPaymentStep2(formID);
  }

  if ($(".new-addres-item").length && !$(".addres-item.active").length) {
    alerter.show("Lütfen önce adres girişinizi yazın.");
    return;
  }
  $("#shopphp-payment-body-step3").html("").css("minHeight", "auto");
  $("#shopphp-payment-body-step2").show().html(ajaxLoaderDiv());
  if ($("#shopphp-payment-body-step2").length)
    $(window).scrollTop($("#shopphp-payment-body-step2").offset().top);
  $.ajax({
    type: "POST",
    url: "page.php?act=satinal&op=adres&viewPopup=1&isAjax=1",
    data: $("#" + formID).serialize(),
    success: function (response) {
      if ($("#shopphp-payment-body-step2").length)
        $("#shopphp-payment-body-step1").hide("fast");
      sepetAdresHTMLGuncelle();
      $.get("include/ajaxLib.php?act=siparisOdemeSecim", function (data) {
        if ($("#shopphp-payment-body-step2").length)
          $("#shopphp-payment-body-step2").html(data);
        else window.location.href = "page.php?act=satinal&op=secim";
        return;
      });
    },
  });
  return false;
}

function shopPHPPaymentStep3(selectedPayType) {
  if (!$("#shopphp-payment-body-step3").length) {
    window.location.href =
      "page.php?act=satinal&op=odeme&paytype=" +
      encodeURIComponent(selectedPayType);
    return;
  }
  $("#shopphp-payment-body-step3").show().html(ajaxLoaderDiv());
  $(window).scrollTop($("#shopphp-payment-body-step3").offset().top);
  $.ajax({
    type: "GET",
    url:
      "page.php?act=satinal&op=odeme&paytype=" +
      encodeURIComponent(selectedPayType) +
      "&viewPopup=1&isAjax=1",
    success: function (response) {
      $("#shopphp-payment-body-step1").hide("fast");
      $("#shopphp-payment-body-step2").hide("fast");
      if ($(response).find("#shopphp-payment-body-step3").html() == null) {
        window.location.href =
          "page.php?act=satinal&op=odeme&paytype=" +
          encodeURIComponent(selectedPayType);
        return;
      }
      $("#shopphp-payment-body-step3").html(
        $(response).find("#shopphp-payment-body-step3").html()
      );
      $("#shopphp-payment-body-step3").css("minHeight", "600px");
      bindCCFunctions();
    },
  });
  return false;
}

function urunAjax(urunID, loadID, listTemp, showTemp) {
  if (!listTemp) listTemp = "empty";
  if (!$(".urun-ajax-" + urunID).length) return;
  $.get(
    "include/ajaxLib.php?act=tek-urun&purunID=" +
      urunID +
      "&urunID=" +
      loadID +
      "&list-temp=" +
      listTemp +
      "&show-temp=" +
      showTemp,
    function (data) {
      $(".urun-ajax-" + urunID).html($(data).html());
    }
  );
}

function urunFiyat(urunID, obj) {
  $.get("include/ajaxLib.php?act=urunFiyat&urunID=" + urunID, function (data) {
    $(obj).val(data);
  });
}

function odemeKontrol(alt) {
  if ($("#odeme-onay").length && !$("#odeme-onay").is(":checked")) {
    alerter.show(alt);
    return false;
  }
  return true;
}

function gfUrunFormSubmit(formID, urunID) {
  var dataSerialize = $("#" + formID).serialize();
  //  $("#" + formID).html(ajaxLoaderDiv());
  $.ajax({
    type: "POST",
    url: "page.php?act=urunDetay&urunID=" + urunID + "&getOnlyResponse=1",
    data: dataSerialize,
    success: function (response) {
      $("#" + formID).html(response);
    },
  });
  return false;
}

function gfSiteFormSubmit(formID, act, data) {
  var dataSerialize = $("#" + formID).serialize();
  $("#" + formID).html(ajaxLoaderDiv());
  $.ajax({
    type: "POST",
    url: "page.php?act=" + act + "&getOnlyResponse=1&data=" + data,
    data: dataSerialize,
    success: function (response) {
      $("#" + formID).html(response);
    },
  });
  return false;
}

function sepetEkleKontrol() {
  sepetEkleKontrolValue = true;
  if (typeof preSepetEkleKontrol == "function") {
    preSepetEkleKontrol();
  }
  if (sepetEkleKontrolValue && typeof preSepetEkleKontrol2 == "function") {
    preSepetEkleKontrol2();
  }
  updateSecimURL();
  if ($("#urunKurallari").length) {
    if (!$("#urunKurallari").is(":checked")) {
      alerter.show(lang_onaySepet);
      sepetEkleKontrolValue = false;
    }
  }
  for (var i = 1; i <= 10; i++) {
    if (
      sepetEkleKontrolValue &&
      $(".urunSecim_ozellik" + i + "detay li").length > 1 &&
      !$(".urunSecim_ozellik" + i + "detay li.selected").length
    ) {
      alerter.show(lang_urunVarSecim);
      sepetEkleKontrolValue = false;
    }
  }

  for (var i = 1; i <= 10; i++) {
    if (
      sepetEkleKontrolValue &&
      $("select[name=ozellik" + i + "detay] option").length > 1 &&
      !$("select[name=ozellik" + i + "detay]").val()
    ) {
      alerter.show(lang_urunVarSecim);
      sepetEkleKontrolValue = false;
    }
  }

  for (var i = 1; i <= 10; i++) {
    if (
      sepetEkleKontrolValue &&
      $("#urunSecim_ozellik" + i + "detay").length &&
      !$("#urunSecim_ozellik" + i + "detay").val()
    ) {
      alerter.show(lang_urunVarSecim);
      sepetEkleKontrolValue = false;
    }
  }
  return sepetEkleKontrolValue;
}

function urunTooltip(urunAdi, gosterim) {
  if (gosterim <= 1) return;
  var str = lang_urunDefaIncelendi;
  str = str.replace(/%gosterim%/i, gosterim).replace(/%urunadi%/i, urunAdi);
  $('<div id="urunTooltip">' + str + "</div>").appendTo("body");
  $("#urunTooltip").fadeTo("fast", 0.7);
  setTimeout(function () {
    $("#urunTooltip").fadeTo("fast", 0, function () {
      $(this).remove();
    });
  }, 5000);
}

function ebultenSubmit(objid) {
  var email = $("#" + objid).val();
  $.ajax({
    url: "include/ajaxLib.php?act=ebulten&email=" + encodeURIComponent(email),
    success: function (data) {
      alerter.show(data);
      $("#" + objid).val("");
    },
  });
  return false;
}

function getPaketAdet(val, plus) {
  val = parseInt(val);
  var r = 0;
  if (!Array.isArray(adetArray)) return 1;
  if (adetArray.length < 2) return 1;
  var index = adetArray.indexOf(val);

  //if(index >= 0 && index < adetArray.length - 1)

  if (adetArray[index + plus]) r = adetArray[index + plus];
  else return 0;
  return (r - val) * plus;
}

function azalt(input) {
  var eskiDeger = input.value;
  var adet = getPaketAdet(eskiDeger, -1);

  yeniDeger = parseInt(input.value) - adet;
  input.value = yeniDeger < adet ? eskiDeger : yeniDeger;
  return false;
}

function arttir(input) {
  var adet = getPaketAdet(input.value, +1);
  input.value = parseInt(input.value) + adet;
  return false;
}

function setImageMaxSideSize(selector, maxWidthSet, maxHeightSet) {
  $(selector).each(function () {
    var maxWidth = maxWidthSet; // Max width for the image
    var maxHeight = maxHeightSet; // Max height for the image
    var ratio = 0; // Used for aspect ratio
    var width = $(this).width(); // Current image width
    var height = $(this).height(); // Current image height

    // Check if the current width is larger than the max
    if (width > maxWidth) {
      ratio = maxWidth / width; // get ratio for scaling image
      $(this).css("width", maxWidth); // Set new width
      $(this).css("height", "auto"); // Scale height based on ratio
      height = height * ratio; // Reset height to match scaled image
      width = width * ratio; // Reset width to match scaled image
    }

    // Check if current height is larger than max
    if (height > maxHeight) {
      ratio = maxHeight / height; // get ratio for scaling image
      $(this).css("height", maxHeight); // Set new height
      $(this).css("width", "auto"); // Scale width based on ratio
      width = width * ratio; // Reset width to match scaled image
      height = height * ratio; // Reset height to match scaled image
    }
  });
}

function ajaxKarsilastir() {
  $.ajax({
    url: "include/ajaxLib.php?act=ajaxKarsilastir",
    success: function (data) {
      window.location.href = "page.php?act=karsilastir&" + data;
      // pencereAc('compare.php?' + data ,800,400);
    },
  });
  return false;
}

function karsilastirmaEkle(urunID) {
  $.ajax({
    url: "include/ajaxLib.php?CookieInsertUrunID=" + encodeURIComponent(urunID),
    success: function (data) {
      $.ajax({
        url: "include/ajaxLib.php?act=karsilastrimaListem",
        success: function (data) {
          $("#karsilastirmaListeBlock").html(data);

          alerter.show(lang_karsilastirmaEklendi);
        },
      });
    },
  });
  return false;
}

function karsilastirmaKaldir(urunID) {
  $.ajax({
    url: "include/ajaxLib.php?CookieRemoveUrunID=" + encodeURIComponent(urunID),
    success: function (data) {
      $.ajax({
        url: "include/ajaxLib.php?act=karsilastrimaListem",
        success: function (data) {
          $("#karsilastirmaListeBlock").html(data);

          alerter.show(lang_karsilastirmaKaldirildi);
        },
      });
    },
  });
  return false;
}

function alarmEkle(ftype, urunID) {
  $.ajax({
    url:
      "include/ajaxLib.php?fa=true&ftype=" +
      encodeURIComponent(ftype) +
      "&urunID=" +
      encodeURIComponent(urunID),
    success: function (data) {
      alerter.show(lang_listeEklendi);
    },
  });
  return false;
}

function updateAnaResim(url, width) {
  return;
}

function uyelikIptal(str) {
  if (confirm(str))
    window.location.href = siteDizini + "page.php?act=logout&remove=true";
}

function updateOptionList(obj, stok) {
  if ($(obj) == null || stok == "") return;
  $(obj).find("option").remove();
  var maxSatis = $(obj).parent().prop("max");
  if (maxSatis) stok = Math.min(stok, maxSatis);
  stok = Math.min(stok, 100);

  for (var i = 0; i <= stok; i++) {
    if (i) $("<option>" + i + "</option>").appendTo(obj);
  }
}

function moneyFormat3(num) {
  var p = num.toFixed(2).split(".");
  var out = (
    "" +
    p[0]
      .split("")
      .reverse()
      .reduce(function (acc, num, i, orig) {
        return num + (i && !(i % 3) ? "," : "") + acc;
      }, "") +
    "." +
    p[1]
  );      
  return out;
}

function updateShopPHPUrunFiyat(fark) {
  if (isNaN(fark)) fark = 0;
  $("#shopPHPUrunFiyatOrg").text(moneyFormat(shopPHPUrunFiyatOrg + fark));
  $("#shopPHPUrunFiyatT").text(
    moneyFormat((shopPHPUrunFiyatOrg + fark) / shopPHPFiyatCarpanT)
  );
  $("#shopPHPUrunFiyatOrg_KH").text(
    moneyFormat((shopPHPUrunFiyatOrg + fark) / (1 + shopPHPUrunKDV))
  );
  $("#shopPHPUrunFiyatYTL").text(
    moneyFormat((shopPHPUrunFiyatOrg + fark) * shopPHPFiyatCarpan)
  );
  $("#shopPHPUrunFiyatYTL_KH").text(
    moneyFormat(
      ((shopPHPUrunFiyatOrg + fark) * shopPHPFiyatCarpan) / (1 + shopPHPUrunKDV)
    )
  );
  $("#shopPHPHavaleIndirim").text(
    moneyFormat(
      (shopPHPUrunFiyatOrg + fark) *
        shopPHPFiyatCarpan *
        (1 - shopPHPHavaleIndirim)
    )
  );
  $("#shopPHPTekCekimOran").text(
    moneyFormat(
      (shopPHPUrunFiyatOrg + fark) *
        shopPHPFiyatCarpan *
        (1 - shopPHPTekCekimOran)
    )
  );
  if (paytrURL)
    $("#paytr_taksit_guncelle").html(
      '<div id="paytr_taksit_tablosu"></div><script src="' +
        paytrURL +
        "&amount=" +
        (shopPHPUrunFiyatOrg + fark) * shopPHPFiyatCarpan +
        '"></script>'
    );
}

var shopPHPUrunFiyatOrg2 = 0;
function updateUrunSecim(urunID, varID, varName, widthDetay, widthList, obj) {
  if (!shopPHPUrunFiyatOrg2) shopPHPUrunFiyatOrg2 = shopPHPUrunFiyatOrg;
  if ($(obj).hasClass("disabled")) {
    //alerter.show(lang_secimStokYok);
    return false;
  }
  if (isMobile) $("html, body").animate({ scrollTop: 0 }, "slow");
  $(obj).parent().find("li").removeClass("selected");
  $(obj).addClass("selected");
  $("input[name=" + varID + "]").val(varName);

  var varurl = "";
  var url = "";
  var currentID = parseInt(varID.replace("ozellik", "").replace("detay", ""));

  for (i = 1; i <= 10; i++) {
    if ($("input[name=ozellik" + i + "detay]").length)
      varurl +=
        "&var" +
        i +
        "=" +
        encodeURIComponent($("input[name=ozellik" + i + "detay]").val());
    if (i > currentID) {
      $("ul.urunSecim_ozellik" + i + "detay li")
        .addClass("disabled")
        .attr("disabled", "disabled")
        .removeClass("selected");
      $("input[name=ozellik" + i + "detay]").val("");
    }
  }

  if ($("input[name=ozellik" + (currentID + 1) + "detay]").length) {
    url =
      "include/ajaxLib.php?act=varListUpdate&seq=" +
      (currentID + 1) +
      "&urunID=" +
      urunID +
      varurl;
    $.get(url, function (data) {
      if (data)
        $("ul.urunSecim_ozellik" + (currentID + 1) + "detay").html(data);
    });
  }

  url = "include/ajaxLib.php?act=varKodKontrol&urunID=" + urunID + varurl;
  $.get(url, function (data) {
    if (data) $("#spUrunKodu").text(data);
  });

  updateSecimURL();
  updateVarResim(urunID, varID, varName);
  ajaxFiyatGuncelle(urunID);
  updateOptionList(".urunSepeteEkleAdet", $(obj).attr("stok"));
  return;
}

function updateVarResim(urunID, varID, varName) {
  // alert(urunID + '-' + varID + '-' + varName);
  var url =
    "include/ajaxLib.php?ajax=1&act=urunResimListContainer&urunID=" +
    encodeURIComponent(urunID);

  $.get(url, function (data) {
    // if(data) $("#urunResimListContainer").html(data);
    //	alert(data);
    var widthDetay = 600;
    varID = varID.replace(/ozellik/i, "").replace(/detay/i, "");
    var url =
      "include/ajaxLib.php?act=urunSecenekSecim&urunID=" +
      encodeURIComponent(urunID) +
      "&urunVarID=" +
      encodeURIComponent(varID) +
      "&urunVarName=" +
      encodeURIComponent(varName) +
      "&r=" +
      Math.floor(Math.random() * 99999);
    $(".lightbox .fancybox").attr("href", "include/resize.php?path=" + url);
    $.ajax({
      url: url,
      success: function (data) {
        $("#loading").remove();
        var obj = jQuery.parseJSON(data);
        if (obj.resim1 == null || !obj.resim1) return;
        $("#urunResimListContainer img").parent().parent().hide();

        var url = "";

        if (obj.resim1) {
          $("#urunResimListContainer img:eq(0)").parent().parent().show();
          url = "images/urunler/" + obj.resim1;
          $(".lightbox:first").attr("href", url);
          $(".lightbox:first img")
            .attr(
              "src",
              "include/resize.php?path=" + url + "&width=" + widthDetay
            )
            .attr("data-zoom-image", url);
          $("#urunResimListContainer img:first")
            .attr("src", "include/resize.php?path=" + url + "&width=300")
            .parent()
            .attr("data-zoom-image", url)
            .attr(
              "data-image",
              "include/resize.php?path=" + url + "&width=" + widthDetay
            )
            .unbind("click");
        }
        if (obj.resim2) {
          $("#urunResimListContainer img:eq(1)").parent().parent().show();
          url = "images/urunler/" + obj.resim2;
          $("#urunResimListContainer img:eq(1)")
            .show()
            .attr("src", "include/resize.php?path=" + url + "&width=300")
            .parent()
            .attr("data-zoom-image", url)
            .attr(
              "data-image",
              "include/resize.php?path=" + url + "&width=" + widthDetay
            )
            .unbind("click");
        } else $("#urunResimListContainer img:eq(1)").parent().parent().hide();

        if (obj.resim3) {
          $("#urunResimListContainer img:eq(2)").parent().parent().show();
          url = "images/urunler/" + obj.resim3;
          $("#urunResimListContainer img:eq(2)")
            .show()
            .attr("src", "include/resize.php?path=" + url + "&width=300")
            .parent()
            .attr("data-zoom-image", url)
            .attr(
              "data-image",
              "include/resize.php?path=" + url + "&width=" + widthDetay
            )
            .unbind("click");
        } else $("#urunResimListContainer img:eq(2)").parent().parent().hide();
        if (obj.resim4) {
          $("#urunResimListContainer img:eq(3)").parent().parent().show();
          url = "images/urunler/" + obj.resim4;
          $("#urunResimListContainer img:eq(3)")
            .show()
            .attr("src", "include/resize.php?path=" + url + "&width=300")
            .parent()
            .attr("data-zoom-image", url)
            .attr(
              "data-image",
              "include/resize.php?path=" + url + "&width=" + widthDetay
            )
            .unbind("click");
        } else $("#urunResimListContainer img:eq(3)").parent().parent().hide();
        if (obj.resim5) {
          $("#urunResimListContainer img:eq(4)").parent().parent().show();
          url = "images/urunler/" + obj.resim5;
          $("#urunResimListContainer img:eq(4)")
            .parent()
            .parent()
            .show()
            .attr("src", "include/resize.php?path=" + url + "&width=300")
            .parent()
            .attr("data-zoom-image", url)
            .attr(
              "data-image",
              "include/resize.php?path=" + url + "&width=" + widthDetay
            )
            .unbind("click");
        } else $("#urunResimListContainer img:eq(4)").hide();
        $("#urunResimListContainer img").bind("click", function (e) {});
        galeri = [];
        var i = 0;
        $.each($("#urunResimListContainer a"), function () {
          galeri.push(
            $("#urunResimListContainer a").eq(i).attr("data-zoom-image")
          ),
            i++;
        });
        galeri[0] = $(".lightbox a").eq(0).attr("href");

        $(".zoomContainer").remove();
        //if (!isMobile)
        {
          $(".lightbox img").unbind("click");
          $(".lightbox img").removeData("elevateZoom");
          $(".lightbox img").removeData("zoomImage");
          $(".lightbox:first img").elevateZoom({
            gallery: "urunResimListContainer",
            easing: true,
          });
          $(".lightbox:first img").bind("click", function (e) {
            var ez = $(".lightbox:first img").data("elevateZoom");
            $.fancybox(ez.getGalleryList());
            return false;
          });
        }
      },
    });
  });
}
function sepeteEkleLink(urunID, obj) {
  updateSecimAppendURL(urunID);
  if (sepetEkleKontrol()) {
    window.location.href =
      siteDizini +
      "page.php?act=sepet&op=ekle&adet=" +
      urunSepeteEkleAdet +
      secimURL +
      "&urunID=" +
      urunID;
    return false;
  }
}

function hemenAlLink(urunID, obj) {
  updateSecimAppendURL(urunID);
  if (sepetEkleKontrol()) {
    window.location.href =
      siteDizini +
      "page.php?act=sepet&op=ekle&adet=" +
      urunSepeteEkleAdet +
      secimURL +
      "&urunID=" +
      urunID +
      "&hemenal=true";
    return false;
  }
}

function ajaxFiyatGuncelle(urunID) {

  $('.old-price,.discount').hide();

  updateSecimURL();
  urunSepeteEkleAdet = $(".urunSepeteEkleAdet_" + urunID).val();
  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = $(".urunSepeteEkleAdet").val();
  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = 1;

  var url =
    "include/ajaxLib.php?ajax=1&act=sepetEkle&urunID=" +
    encodeURIComponent(urunID) +
    "&adet=" +
    encodeURIComponent(urunSepeteEkleAdet) +
    "&" +
    secimURL +
    "&showprice=true";

  $.get(url, function (data) {
    var m = data.split("|");
    m[0] = parseFloat(m[0]);
    m[1] = parseFloat(m[1]);
    if(!m[1]) return;
    if(isNaN(m[0]))
      return;
    $("#shopPHPUrunFiyatOrg").text(moneyFormat(m[1]));
    $("#shopPHPUrunFiyatT").text(moneyFormat(m[1]));
    $("#shopPHPUrunFiyatOrg_KH").text(moneyFormat(m[1] / (1 + shopPHPUrunKDV)));
    $("#shopPHPUrunFiyatYTL").text(moneyFormat(m[0]));
    $("#shopPHPUrunFiyatYTL_KH").text(
      moneyFormat((m[1] * 1) / (1 + shopPHPUrunKDV))
    );
    $("#shopPHPHavaleIndirim").text(
      moneyFormat(m[1] * 1 * (1 - shopPHPHavaleIndirim))
    );
    $("#shopPHPTekCekimOran").text(
      moneyFormat(m[1] * 1 * (1 - shopPHPTekCekimOran))
    );
  });
}

function sepeteEkle(urunID, obj) {
  if (typeof mySepeteEkle == "function") {
    return mySepeteEkle(urunID, obj);
  }

  updateSecimURL();
  urunSepeteEkleAdet = $(".urunSepeteEkleAdet_" + urunID).val();
  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = $(".urunSepeteEkleAdet").val();
  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = 1;

  sepetEkleKontrol();

  if (sepetEkleKontrolValue) {
    var url =
      "include/ajaxLib.php?ajax=1&act=sepetEkle&urunID=" +
      encodeURIComponent(urunID) +
      "&adet=" +
      encodeURIComponent(urunSepeteEkleAdet) +
      "&" +
      secimURL;
    $.get(url, function (data) {
      if (data == "urun_link")
        window.location.href =
          siteDizini +
          "page.php?act=sepet&op=ekle&adet=" +
          urunSepeteEkleAdet +
          "&urunID=" +
          urunID;
      else if (data == "urun_var")
        alerter.show("Ürün daha önce sepetinize eklenmiş");
      else if (data == "urun_stok_yok")
        alerter.show(lang_stoktaOlmayanUrunuEkleyemezsiniz);
      else {
        swal({
          text: "Ürün sepetinize eklendi.",
          timer: 1500,
          type: "info",
          icon: "success",
          button: lang_OK,
          showConfirmButton: false,
          showCancelButton: false,
        });
        sepetHTMLGuncelle("");
        $(".urunSecim li").removeClass("selected");
        $(
          "#urunSecim_ozellik1detay,#urunSecim_ozellik2detay,#urunSecim_ozellik3detay"
        ).val("");
      }
      secimURL = "";
    });
  }
  return false;
}

function updateSepetBilgi(selector, act) {
  var url = "include/ajaxLib.php?act=sepetBilgi&op=" + encodeURIComponent(act);
  $.get(url, function (data) {
    $(selector).html(data);
  });
}

function multiSepetEkle() {
  //$(obj).parent().html(lang_lutfenBekleyin);

  var url =
    "include/ajaxLib.php?act=sepetEkle&urunID=" +
    encodeURIComponent($("#relUrunID").val()) +
    "&adet=" +
    encodeURIComponent(urunSepeteEkleAdet) +
    "&ajax=1";
  //window.open(url);
  $.get(url, function (data) {
    //alert(data);
    $("#sepetGoster").html(data);
  });

  for (var i = 0; i <= 10; i++) {
    if (
      $("#adet_" + i).val() &&
      $("#adet_" + i).val() >= 1 &&
      $("#adet_" + i).is(":checked")
    ) {
      var url =
        "include/ajaxLib.php?act=sepetEkle&urunID=" +
        encodeURIComponent($("#relUrunID").val()) +
        "&adet=" +
        $("#adet_" + i).val() +
        "&beraberUrunler=" +
        $("#adet_" + i).attr("urunID") +
        "&ekle_adet_" +
        $("#adet_" + i).attr("urunID") +
        "=" +
        $("#adet_" + i).val() +
        "&relUrunID=" +
        $("#relUrunID").val();

      $.get(url, function (data) {
        //alert(url + ' : ' + data);
        $("#sepetGoster").html(data);
      });
    }
  }
  setTimeout(function () {
    window.location.href = siteDizini + "page.php?act=sepet&x=1";
  }, 2000);
  return false;
}

function changeSPSlide(obj, num, total) {
  num = Math.round(num % total);
  $(obj).find(".spSlide").hide("fast");
  $(obj)
    .find(".spSlide:eq(" + num + ")")
    .fadeIn("slow");
  setTimeout(function () {
    changeSPSlide(obj, num + 1, total);
  }, 5000);
}

function tckimlikkontorolu(KimlikNo) {
  KimlikNo = String(KimlikNo);
  if (!KimlikNo.match(/^[0-9]{11}$/)) return false;

  pr1 = parseInt(KimlikNo.substr(0, 1));
  pr2 = parseInt(KimlikNo.substr(1, 1));
  pr3 = parseInt(KimlikNo.substr(2, 1));
  pr4 = parseInt(KimlikNo.substr(3, 1));
  pr5 = parseInt(KimlikNo.substr(4, 1));
  pr6 = parseInt(KimlikNo.substr(5, 1));
  pr7 = parseInt(KimlikNo.substr(6, 1));
  pr8 = parseInt(KimlikNo.substr(7, 1));
  pr9 = parseInt(KimlikNo.substr(8, 1));
  pr10 = parseInt(KimlikNo.substr(9, 1));
  pr11 = parseInt(KimlikNo.substr(10, 1));

  if ((pr1 + pr3 + pr5 + pr7 + pr9 + pr2 + pr4 + pr6 + pr8 + pr10) % 10 != pr11)
    return false;
  if (
    ((pr1 + pr3 + pr5 + pr7 + pr9) * 7 + (pr2 + pr4 + pr6 + pr8) * 9) % 10 !=
    pr10
  )
    return false;
  if (((pr1 + pr3 + pr5 + pr7 + pr9) * 8) % 10 != pr11) return false;

  return true;
}

function teklifFiyatGuncelle() {
  var ToplamKDVDahil = 0;
  var ToplamKDVHaric = 0;
  var KDVDahil = 0;
  var KDVHaric = 0;
  var KDV = 0;
  $("table.teklif tr.teklifSatir").each(function () {
    KDV = $(this).find(".kdv").text().replace(/\%/i, "");
    KDVDahil =
      $(this).find(".adet").val() *
      $(this).find(".fiyat").val().replace(/,/i, "");
    KDVHaric = KDVDahil / (1 + KDV / 100);
    ToplamKDVDahil += KDVDahil;
    ToplamKDVHaric += KDVHaric;
    $(this).find(".toplam").text(moneyFormat(KDVDahil));
  });
  $("#kdvdahil").html(moneyFormat(ToplamKDVDahil));
  $("#kdvharic").html(moneyFormat(ToplamKDVHaric));
  $("#toplamkdv").html(moneyFormat(ToplamKDVDahil - ToplamKDVHaric));
  $("#toplamytl").html(moneyFormat(ToplamKDVDahil));
  $("#dolar").html(moneyFormat(ToplamKDVDahil / dolar));
  $("#euro").html(moneyFormat(ToplamKDVDahil / euro));
}

function setSCity(city) {
  $.ajax({
    url: "include/ajaxLib.php?act=setCitySession&city=" + city,
    type: "GET",
    success: function (data) {
      //alert(data);
      window.location.reload();
    },
  });
}

function setSCountry(cnt) {
  $.ajax({
    url: "include/ajaxLib.php?act=setCountrySession&cnt=" + cnt,
    type: "GET",
    success: function (data) {
      //alert(data);
      window.location.reload();
    },
  });
}

function setFilterSession() {
  var seoURLAdd = "";
  var queryFilter = "";
  $("input.filterCheck").each(function () {
    if ($(this).is(":checked")) {
      queryFilter +=
        "queryFilter[]=" +
        $(this).attr("filterKey") +
        "::" +
        $(this).attr("filterValue") +
        "&";
      if (seoURLAdd) seoURLAdd += "-";
      seoURLAdd +=
        $(this).attr("filterKey") + "_" + $(this).attr("filterValue");
    }
  });
  if ($("#fiyat_slider3").length)
    queryFilter +=
      "queryFilter[]=" +
      $("#fiyat_slider3").attr("filterKey") +
      "::" +
      $("#fiyat_slider3").val().replace(";", " - ") +
      "&";
  $.ajax({
    url: "include/ajaxLib.php?act=setFilterSession",
    type: "POST",
    data: queryFilter,
    success: function (data) {
      //alert(data);
      data = decodeEntities(data);
      window.location.href = data;
      return;

      var url = window.location.href;
      url = url.replace(/page=[0-9]*/i, "page=1&");
      url = url.replace(/-p.[0-9]*\-/i, "_filter__" + seoURLAdd + "-p1-");

      // window.location.href = data;
    },
  });
}

function decodeEntities(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

var mouseX, mouseY;
$(document)
  .mousemove(function (e) {
    mouseX = e.pageX;
    mouseY = e.pageY;
  })
  .mouseover(); // call the handler immediately

function bindCCFunctions() {
  $("input.cardno").bind("keydown", function (event) {
    if (event.keyCode == 32) {
      return false;
    }
  });

  //$('input[name$="cardno"],input.cardno').keypad({keypadOnly:false});
  $(".card-number").change(function () {
    if ($(this).hasClass("est-card-number")) return;
    if ($(this).val().length == 4) {
      $(this).next().focus();
    }
  });
  $(".card-number").keyup(function () {
    if ($(this).hasClass("est-card-number")) return;
    if ($(this).val().length == 4) {
      $(this).next().focus();
    }
  });
  $("span.button")
    .parents("form:first")
    .submit(function () {
      if (!stopSubmit) $(this).find("span.button").html(lang_lutfenBekleyin);
    });
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if (new Date().getTime() - start > milliseconds) {
      break;
    }
  }
}

function saveSiparisForm(formID, op) {
  if (!formID) return;
  $.ajax({
    type: "POST",
    url: "page.php?act=satinal&op=adres",
    data: $("#" + formID).serialize(),
    success: function (response) {
      $.ajax({
        type: "GET",
        url: "page.php?act=onay&tp=" + op + "&viewPopup=1&r=" + Math.random(),
        success: function (response) {
          $(".fancybox-inner textarea").html(
            $(response).find("textarea").html()
          );
        },
      });
    },
  });
}

$(document).ready(function () {
  // device detection
  if (
    /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(
      navigator.userAgent
    ) ||
    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
      navigator.userAgent.substr(0, 4)
    )
  )
    isMobile = true;

  $("#gf_email").keyup(function (e) {
    if (e.which === 32) return false;
  });

  $("#gf_ceptel,#gf_evtel,#gf_istel,.input-tel input").mask("(Z00) 000-0000", {
    translation: {
      Z: {
        pattern: /[1-9]/,
        optional: false,
      },
    },
  });

  $("#gf_ebulten,#ebultenSMS").val("1");
  if ($(".basket-wrap").parent().width() < 1000)
    $(".basket-wrap").addClass("basket-tek");
  $(".basket-wrap").css("visibility", "visible");
  alerter = new Alerter();

  $("input[name=odemeSelect]:checked").click();

  $("#gf_odemeTipi").change(function () {
    sepetSecimGuncelle($(this).val(), 0);
  });
  $(".karlastirma-liste-checkbox").click(function () {
    if ($(this).is(":checked"))
      karsilastirmaEkle($(this).attr("id").replace("k_", ""));
    else karsilastirmaKaldir($(this).attr("id").replace("k_", ""));
  });
  // $('.qty').change(function() { sepetAdetGuncelle($(this).attr('id').replace('sepetadet_',''),$(this).val()); return false; });
  // $('ul.urunSecim_ozellik1detay li').addClass('renk filterCheck').each(function() { $(this).addClass($(this).attr('value')); })

  $("#gf_ceptel_alanKodu,#gf_istel_alanKodu,#gf_evtel_alanKodu").keyup(
    function (e) {
      if ($(this).val().length == 4)
        $("#" + $(this).attr("id").replace("alanKodu", "tel")).focus();
    }
  );

  $("input[name=uye-tipi]").click(function () {
    $(".bireysel,.kurumsal").hide();
    var className = $(this).attr("id");
    $("." + className).show();
  });
  $("input[name=uye-tipi]:first").click();
  $("#urunsirala input").click(function () {
    $("#urunsirala").submit();
  });

  $("a.viewStnOB").fancybox({
    beforeLoad: function () {
      var formID = $("a.viewStnOB").parent().attr("formID");
      saveSiparisForm(formID, "onsatis");
    },
    scrolling: "no",
    padding: 10,
    centerOnScroll: true,
    href: "page.php?act=onay&tp=onsatis&viewPopup=1&r=" + Math.random(),
    type: "ajax",
    'onCleanup': function () {
      var myContent = this.href;
      $(myContent).unwrap();
  }
  });

  $("a.viewStnKVKK").fancybox({
    beforeLoad: function () {
      var formID = $("a.viewStnKVKK").parent().attr("formID");
      saveSiparisForm(formID, "kvkk");
    },
    scrolling: "no",
    padding: 10,
    centerOnScroll: true,
    href: "page.php?act=onay&tp=kvkk&viewPopup=1&r=" + Math.random(),
    type: "ajax",
    'onCleanup': function () {
      var myContent = this.href;
      $(myContent).unwrap();
  }
  });

  $("a.viewStnSAK").fancybox({
    beforeLoad: function () {
      var formID = $("a.viewStnSAK").parent().attr("formID");
      saveSiparisForm(formID, "satinalma");
    },
    scrolling: "no",
    padding: 10,
    centerOnScroll: true,
    href: "page.php?act=onay&tp=satinalma&viewPopup=1&r=" + Math.random(),
    type: "ajax",
    'onCleanup': function () {
      var myContent = this.href;
      $(myContent).unwrap();
  }
  });

  $("#shopphp-payment-title-step1").click(function () {
    $("#shopphp-payment-body-step2,#shopphp-payment-body-step3").hide("fast");
    if ($("#shopphp-payment-body-step1").find("input").length) {
      $("#shopphp-payment-body-step1").show("fast");
    } else {
      $("#shopphp-payment-body-step1").show("fast").html(ajaxLoaderDiv());
      $.get("include/ajaxLib.php?act=viewForm", function (data) {
        $("#shopphp-payment-body-step1").html(data);
      });
    }
  });
  $("#shopphp-payment-title-step2").click(function () {
    if ($("#shopphp-payment-body-step1").find(".sf-button").length) {
      $("#shopphp-payment-body-step1").find(".sf-button").click();
    } else {
      $("#shopphp-payment-body-step2").show("fast").html(ajaxLoaderDiv());
      $.get("include/ajaxLib.php?act=siparisOdemeSecim", function (data) {
        $("#shopphp-payment-body-step2").show("fast").html(data);
        if ($(data).find("input").length)
          $("#shopphp-payment-body-step1,#shopphp-payment-body-step3").hide(
            "fast"
          );
      });
    }
  });

  $("select.urunSecim").change(function () {
    var varurl = "";
    var url = "";
    var selectName = $(this).attr("name");
    var currentID = parseInt(
      selectName.replace("ozellik", "").replace("detay", "")
    );

    for (i = 1; i <= 10; i++) {
      if ($("select[name=ozellik" + i + "detay]").length)
        varurl +=
          "&var" +
          i +
          "=" +
          encodeURIComponent($("select[name=ozellik" + i + "detay]").val());
      if (i > currentID) {
        $("select[name=ozellik" + i + "detay]")
          .attr("disabled", "disabled")
          .val("");
      }
    }

    if ($("select[name=ozellik" + (currentID + 1) + "detay]").length) {
      url =
        "include/ajaxLib.php?act=varSelectUpdate&seq=" +
        (currentID + 1) +
        "&urunID=" +
        encodeURIComponent($("select[name=ozellik1detay]").attr("urunID")) +
        varurl;
      $.get(url, function (data) {
        $("select[name=ozellik" + (currentID + 1) + "detay]").removeAttr(
          "disabled"
        );
        if (data)
          $("select[name=ozellik" + (currentID + 1) + "detay]").html(data);
      });
    }

    url =
      "include/ajaxLib.php?act=varKodKontrol&urunID=" +
      encodeURIComponent($("select[name=ozellik1detay]").attr("urunID")) +
      varurl;
    $.get(url, function (data) {
      if (data) $("#spUrunKodu").text(data);
    });

    updateVarResim(
      $(this).attr("urunID"),
      $(this).attr("varID"),
      $(this).val()
    );
    ajaxFiyatGuncelle($(this).attr("urunID"));
  });

  $(".filterComboSelect").change(function () {
    var id = $(this).attr("formid");
    $("#" + id).submit();
  });
  $('input[type="submit"]').click(function () {
    $(this).removeAttr("disabled");
  });
  $("div.button").click(function () {
    $(this).find("input").removeAttr("disabled").click();
  });

  $(".dec,.azalt").click(function () {
    var simdiAdet = parseFloat($(".urunSepeteEkleAdet").val());
    if (simdiAdet > 1) simdiAdet--;
    $(".urunSepeteEkleAdet").val(simdiAdet);
    return false;
  });
  $(".inc,.arttir").click(function () {
    var simdiAdet = parseFloat($(".urunSepeteEkleAdet").val());
    simdiAdet++;
    $(".urunSepeteEkleAdet").val(simdiAdet);
    return false;
  });

  $("#fatura").click(function () {
    if ($(this).is(":checked")) $(".fatura").show();
    else $(".fatura").hide();
  });
  $('input[type="password"]').val("");
  $(".tooltip").tooltipster({ animation: "slide", speed: 100 });
  $(".iconListe").parent().css({ position: "relative" });
  $("#filterContainer input.filterCheck").change(function () {
    setFilterSession();
  });
  $("#gf_password").reviewPassword({
    preventWeakSubmit: false,
  });
  $("#gf_kargoFirmaID,#gf_city,#gf_semt").change(function () {
    if ($("#gf_kargoFirmaID").val() != "") {
      $.ajax({
        url:
          "include/ajaxLib.php?act=kargoTutar&kargoFirmaID=" +
          $("#gf_kargoFirmaID").val() +
          "&data_country=" +
          encodeURIComponent($("#gf_country").val()) +
          "&data_city=" +
          encodeURIComponent($("#gf_city").val()) +
          "&data_semt=" +
          encodeURIComponent($("#gf_semt").val()) +
          "&r=" +
          Math.random(),
        success: function (data) {
          $("#gf_info_kargoFirmaID").removeClass("sf-icon").html(data);
        },
      });
    } else $("#gf_info_kargoFirmaID").html("");
  });
  $(".multiSepetCheckbox").each(function () {
    msc++;
    $(this).attr("id", "adet_" + msc);
  });

  $(".multiSepetCheckbox").click(function () {
    $("#caprazToplamAdet").text($(".multiSepetCheckbox:checked").length);
    var toplam = 0;
    $(".multiSepetCheckbox:checked").each(function () {
      toplam += parseFloat($(this).attr("kazanc"));
    });
    $("#caprazToplamKazanc").text(moneyFormat(toplam));
  });

  $("li[disabled=disabled]").addClass("disabled");
  $("table.teklif input").keyup(teklifFiyatGuncelle);
  $("#arttir,#azalt").click(function () {
    var obj = this;
    $("table.teklif .fiyat").each(function () {
      if ($(obj).prop("id") == "arttir")
        $(this).val(moneyFormat($(this).val() * (1 + $("#oran").val() / 100)));
      else
        $(this).val(moneyFormat($(this).val() * (1 - $("#oran").val() / 100)));
    });
    teklifFiyatGuncelle();
  });

  $(".MenuContainer").show();
  $(".HarfListe .Harf:last").css({ borderRight: "none" });
  $(".SubMenuItem a").each(function () {
    $(this).css({ marginLeft: $(this).prop("level") * 10 + "px" });
    if ($(this).prop("level") == 1)
      $(this).css({ padding: "0", background: "none" });
  });
  $(".FilitreKategori").css({
    width: $(".FilitreKategoriListe").width() / 3 - 40 + "px",
  });
  $("body").css("overflowX", "hidden");
  $(".spSlides").each(function () {
    var totalSlides = $(this).find(".spSlide").size();
    changeSPSlide(this, 0, totalSlides);
  });

  $("#detailSearchKey,.detailSearchKey").autocomplete(
    "include/ajaxLib.php?act=arama",
    {
      minChars: 2,
      width: 300,
      multiple: false,
      matchContains: true,
      formatItem: formatItem,
      formatResult: formatResult,
      selectFirst: false,
    }
  );

  if (!isMobile) {
    $("a.fancybox-iframe").fancybox({
      type: "iframe",
      autoSize: true,
      afterLoad: function () {
        $.extend(this, {});
      },
      afterClose: function () {
        sepetHTMLGuncelle("");
      },
    });

    $(".lightbox:first").each(function () {
      $(this).find("img:first").attr("data-zoom-image", $(this).attr("href"));
    });
    $(".lightbox:first img").elevateZoom({
      gallery: "urunResimListContainer",
      easing: true,
    });
    $(".lightbox:first img").bind("click", function (e) {
      var ez = $(".lightbox:first img").data("elevateZoom");
      $.fancybox(ez.getGalleryList());
      return false;
    });
    if ($(".lightbox img").length == 0)
      $(".lightbox").fancybox({
        openEffect: "elastic",
        closeEffect: "elastic",
        helpers: { title: { type: "inside" } },
      });
  } else {
    $("#urunResimListContainer a").click(function () {
      $(".lightbox:first img").attr("src", $(this).attr("data-zoom-image"));
    });
    $(".lightbox").removeAttr("href");
  }
  $("#imgSepetGoster,.imgSepetGoster").click(function () {
    if ($("body").width() < 700) {
      window.location.href = "page.php?act=sepet";
      return true;
    }
    if (!$("#sepetGoster").is(":visible")) {
      $("#sepetGoster").slideDown(200);
      $("#sepetGoster").css({
        top: mouseY + 40 + "px",
        left: mouseX - parseInt($("#sepetGoster").width()) + "px",
      });
    } else {
      $("#sepetGoster").slideUp(200);
    }
    return false;
  });

  $(".imgCaptchaRefresh").click(function () {
    $(this)
      .parent()
      .find(".imgCaptcha")
      .attr({ src: "include/create_captcha.php?u=1&" + Math.random() });
  });
  $("#gf_country,#gf_country2").change(function () {
    formCountryChange(this);
  });
  $("#gf_city,#gf_city2").change(function () {
    formCityChange(this);
  });
  $("#gf_semt").change(function () {
    if (!$("#gf_semt2").html()) return;
    var errorID = $(this).prop("id").replace(/gf_/i, "error_");
    $("#" + errorID).text("");
    $(".generatedForm .button").show();
    if ($(this).find("option:selected").attr("kargo") == 0) {
      $("#" + errorID).text(" " + lang_ilceGonderimYok);
      $(".generatedForm .button").hide();
    }
    if (
      $(this).find("option:selected").attr("fiyatfarki") != 0 &&
      $(this).find("option:selected").attr("fiyatfarki")
    ) {
      var str = lang_ilceKargoFark;
      str = str.replace(
        /%fark%/i,
        $(this).find("option:selected").attr("fiyatfarki")
      );
      $("#" + errorID).text(" " + str);
    }
  });
  if ($("#gf_city").html()) formCityChange($("#gf_city"));
  if ($("#gf_country").html()) formCountryChange($("#gf_country"));

  $(".fillAddress").change(function () {
    var preFix = $(this).attr("addressPrefix");
    var pars = "act=addressList&adresID=" + encodeURIComponent($(this).val());
    $.ajax({
      url: "include/ajaxLib.php?" + pars,
      success: function (data) {
        var dataArray = data.split("||");
        $("#gf_address" + preFix).val(dataArray[0]);
        $("#gf_city" + preFix).val(dataArray[1]);
        var pars = "act=town&cityID=" + dataArray[1];
        $.ajax({
          url: "include/ajaxLib.php?" + pars,
          success: function (data) {
            $("#gf_semt" + preFix).html(data);
            $("#gf_semt" + preFix).val(dataArray[2]);
          },
        });
      },
    });
  });
  $(".sepeteEkleAdet").click(function () {
    $(this).val("");
  });
  //$('.sepeteEkleAdet[max=0]').attr('disabled','disabled');
  $(".sepeteEkleAdet").keyup(function (e) {
    var key = e.charCode || e.keyCode || 0;

    var total = $(this).val();
    urunSepeteEkleAdet = total;
    return;
    var OK =
      key == 8 ||
      key == 9 ||
      key == 46 ||
      (key >= 37 && key <= 40) ||
      (key >= 48 && key <= 57) ||
      (key >= 96 && key <= 105);
    if (is_int(total)) {
      OK = true;
      urunSepeteEkleAdet = total;
      return true;
    }
    if (OK) {
      if (parseInt(total) > $(this).prop("max")) {
        $(this).val($(this).prop("max"));
        alerter.show(lang_urunStoguAsanDeger);
        urunSepeteEkleAdet = $(this).val();
        return false;
      }
      urunSepeteEkleAdet = total;
      return true;
    } else return false;
  });
  bindCCFunctions();
  $(".urunSecimTable select").change(updateSecimURL);
  updateSecimURL();
  if (pushAlert.length > 0) alerter.show(pushAlert);
  $('a[href="#"]').click(function () {
    return false;
  });
  $(".piyasa-indirim").each(function () {
    if ($(this).text() == "%" || !$(this).text()) $(this).remove();
  });
  $(".fancybox").fancybox({
    afterLoad: function () {
      this.wrap.find(".fancybox-inner").css({
        overflowY: "auto",
        overflowX: "hidden",
      });
    },
  });
});

function adresSil(obj) {
  if (
    !confirm(
      "Bu adres silmek istediğinizden emin misiniz? Bu işlem geri alınamaz."
    )
  )
    return;
  $.ajax({
    url:
      "include/mod_SiparisAdresSecim.php?deleteAjaxAddressID=" +
      $(obj).attr("addressID"),
    type: "GET",
    success: function (data) {
      window.location.reload();
    },
  });
  return false;
}

function adresKayit(obj, formID) {
  var checkFor = [
    "name",
    "lastname",
    "city",
    "semt",
    "address",
    "baslik",
    "ceptel",
  ];
  for (i = 0; i < checkFor.length; i++) {
    if (
      !$(formID)
        .find("[name='" + checkFor[i] + "']")
        .val()
    ) {
      alerter.show(lang_eksiksizDoldurun);
      $(formID)
        .find("[name='" + checkFor[i] + "']")
        .focus();
      return false;
    }
  }

  if ($(formID).find("[name='ceptel']").val().length < 14) {
    alerter.show(lang_eksiksizDoldurun);
    $(formID).find("[name='ceptel']").focus();
    return false;
  }

  $.ajax({
    url:
      "include/mod_SiparisAdresSecim.php?setAjaxAddressID=" +
      $(obj).attr("addressID"),
    type: "POST",
    data: $(formID).serialize(),
    success: function (data) {
      window.location.reload();
    },
  });
  return false;
}

function adresGuncelle(obj) {
  $.fancybox({
    autoSize: true,
    href:
      "include/mod_SiparisAdresSecim.php?getAjaxAddressID=" +
      $(obj).attr("addressID"),
    type: "ajax",
  });
  return false;
}

function updateSecimAppendURL(urunID) {
  urunSepeteEkleAdet = $(".urunSepeteEkleAdet_" + urunID).val();
  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = $(".urunSepeteEkleAdet").val();
  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = $(".sepeteEkleAdet").val();

  if (!urunSepeteEkleAdet) urunSepeteEkleAdet = 1;

  secimURLAppend = "";

  for (i = 1; i <= 50; i++) {
    if (
      $(".urunSecim.urunSecim_" + urunID + "_ozellik" + i + "detay li.selected")
        .length
    )
      secimURLAppend +=
        "&ozellik" +
        i +
        "detay=" +
        encodeURIComponent(
          $(
            ".urunSecim.urunSecim_" +
              urunID +
              "_ozellik" +
              i +
              "detay li.selected"
          ).attr("value")
        );
  }
}

function updateSecimURL() {
  if ($(".urunSepeteEkleAdet").length > 0)
    urunSepeteEkleAdet = parseFloat($(".urunSepeteEkleAdet").val());
  secimURL = "";

  for (i = 1; i <= 50; i++) {
    if ($("#urunSecim_ozellik" + i + "detay").val())
      secimURL +=
        "&ozellik" +
        i +
        "detay=" +
        encodeURIComponent($("#urunSecim_ozellik" + i + "detay").val());
  }
  if ($("#freeID").val())
    secimURL += "&freeID=" + encodeURIComponent($("#freeID").val());
  if ($("#combineID").val())
    secimURL += "&combineID=" + encodeURIComponent($("#combineID").val());
  secimURL += secimURLAppend;
}

function formCountryChange(obj) {
  if (!$(obj).val()) return;
  var cityID = $(obj)
    .attr("id")
    .replace(/country/i, "city");
  $("#" + cityID).html("<option>" + lang_yukleniyor + "</option>");
  var semtID = $(obj)
    .attr("id")
    .replace(/country/i, "semt");

  if ($(obj).val() != "1")
    $("#" + semtID)
      .html("")
      .parent()
      .hide();
  else {
    $("#" + semtID)
      .parent()
      .show();
    $("#" + semtID).html("");
  }
  var pars = "act=city&cID=" + $(obj).val();
  $.ajax({
    url: "include/ajaxLib.php?" + pars,
    success: function (data) {
      var selected = $("#" + cityID).attr("secili");
      $("#" + cityID).html(data);
      $("#" + cityID + " option[value='" + selected + "']").attr(
        "selected",
        "selected"
      );
      if (isMobile) $("#" + cityID).selectmenu("refresh", true);
    },
  });
  return true;
}

function formCityChange(obj) {
  if (!$(obj).val()) return;
  var semtID = $(obj).attr("id").replace(/city/i, "semt");
  $("#" + semtID).html("<option>" + lang_yukleniyor + "</option>");
  var pars = "act=town&for=" + semtID + "&cityID=" + $(obj).val();
  if ($("#" + semtID).attr("filter") == "true") pars += "&valid=true";
  $.ajax({
    url: "include/ajaxLib.php?" + pars,
    success: function (data) {
      var selected = $("#" + semtID).attr("secili");
      $("#" + semtID).html(data);
      $("#" + semtID + " option[value='" + selected + "']").attr(
        "selected",
        "selected"
      );
      if (isMobile) $("#" + semtID).selectmenu("refresh", true);
    },
  });
  return true;
}

function trim(stringToTrim) {
  return stringToTrim.replace(/^\s+|\s+$/g, "");
}

function checkSimpleCaptcha(formID) {
  var pars = "txtCaptcha=" + $("." + formID + "_txtCaptcha").val();
  $.ajax({
    url: "include/ajaxLib.php?act=simplecaptcha",
    type: "POST",
    data: pars,
    success: function (data) {
      data = trim(data);
      if (data == "false" || !data) {
        alerter.show("Güvenlik kodu hatalı.");
      } else {
        $(".formdeger").val(data);
        $("#" + formID).submit();
      }
    },
  });
}

function checkCaptcha(formID) {
  var pars =
    "recaptcha_challenge_field=" +
    $("#recaptcha_challenge_field").val() +
    "&recaptcha_response_field=" +
    $("#recaptcha_response_field").val();
  $.ajax({
    url: "include/ajaxLib.php?act=captcha",
    type: "POST",
    data: pars,
    success: function (data) {
      data = trim(data);
      if (data == "false" || !data) {
        alerter.show("Güvenlik kodu hatalı.");
        Recaptcha.reload();
      } else {
        $(".formdeger").val(data);
        $("#" + formID).submit();
      }
    },
  });
}
var ArkadasimaGonderWidth = 450;
var ArkadasimaGonderHeight = 440;

function arkadasimaGonderPopup(urunID) {
  window.open(
    "popup.php?act=arkadasimaGonder&urunID=" + urunID,
    "_blank",
    "width=" + ArkadasimaGonderWidth + ",height=" + ArkadasimaGonderHeight
  );
  return false;
}

function formatItem(row) {
  return (
    '<img src="include/resize.php?path=images/urunler/' +
    row[0] +
    '&width=20&height=20"> ' +
    row[1]
  );
}
function formatResult(row) {
  return row[1];
  //return row[0].replace(/(<.+?>)/gi, '');
}

function getHash(
  clientId,
  oid,
  amount,
  okUrl,
  failUrl,
  islemtipi,
  taksit,
  rnd,
  storekey
) {
  var hash = "";
  var taksitstr = "";
  if (taksit > 1) taksitstr = taksit;
  var pars =
    "act=getHash&clientId=" +
    clientId +
    "&oid=" +
    oid +
    "&amount=" +
    amount +
    "&okUrl=" +
    okUrl +
    "&failUrl=" +
    failUrl +
    "&islemtipi=" +
    islemtipi +
    "&taksit=" +
    taksitstr +
    "&rnd=" +
    rnd +
    "&storekey=" +
    storekey;
  $.ajax({
    url: "include/ajaxLib.php?" + pars,
    success: function (data) {
      data = trim(data);
      $("#hash").val(data);
    },
  });
  return hash;
}

function getHashGaranti(
  strTerminalID,
  strOrderID,
  strAmount,
  strSuccessURL,
  strErrorURL,
  strType,
  taksit,
  strStoreKey,
  SecurityData
) {
  var hash = "";
  var taksitstr = "";
  if (taksit > 1) taksitstr = taksit;

  var pars =
    "act=getHashGaranti&strTerminalID=" +
    strTerminalID +
    "&strOrderID=" +
    strOrderID +
    "&strAmount=" +
    strAmount +
    "&strSuccessURL=" +
    strSuccessURL +
    "&strErrorURL=" +
    strErrorURL +
    "&strType=" +
    strType +
    "&taksit=" +
    taksitstr +
    "&strStoreKey=" +
    strStoreKey +
    "&SecurityData=" +
    SecurityData;
  $.ajax({
    url: "include/ajaxLib.php?" + pars,
    success: function (data) {
      data = trim(data);
      $("#hash").val(data);
    },
  });
  return hash;
}
// Üst Kategori Listesi Fonksiyonları

var topCatID = 0;
var topMarkaID = 0;
var urunCatInsert = "";
var urunMarkaInsert = "";
var userNameError = "";
var emailNameError = "";

function checkRegisterStatus() {
  $("#sp_registerForm span.button").html(lang_lutfenBekleyin);
  return true;
}

function checkAvail(value, type) {
  $.ajax({
    url:
      "include/ajaxLib.php?act=checkAvail&str=" +
      encodeURIComponent(value) +
      "&type=" +
      encodeURIComponent(type),
    success: function (data) {
      data = trim(data);
      if (data != "OK") {
        if (type == "username") {
          userNameError = "true";
          $("#sp_registerForm .gf_username").focus();
          alerter.show(data);
        }
        if (type == "email" && userNameError == "false") {
          emailNameError = "true";
          $("#sp_registerForm .gf_email").focus();
          alerter.show(data);
        }
      } else {
        if (type == "username") {
          userNameError = "false";
        }
        if (type == "email") {
          emailNameError = "false";
        }
      }
      if (userNameError == "false" && emailNameError == "false")
        $("#sp_registerForm .generatedForm").submit();
    },
  });
}

function updateSubCats(sID) {
  document.getElementById("opt2").options.length = 1;
  document.getElementById("opt2").options[0].text = lang_lutfenBekleyin;
  var url = "include/ajaxLib.php?act=topSubCategory&catID=" + sID;
  $.ajax({
    url: url,
    success: function (data) {
      if (data != "" && data.length > 5 && !(lastFocusedId == "gf_" + type)) {
        upOptions("opt2", data);
      }
    },
  });
  updateSubMarka(sID);
}

function sistemTeklifeEkle() {
  var stop = false;
  var secilenUrunArray = new Array();
  var secilenAdetArray = new Array();
  for (var i = 1; i <= toplamkategori; i++) {
    catID = catNum[i];
    var urunID = document.getElementById("urunSelected_" + catID).options[
      document.getElementById("urunSelected_" + catID).selectedIndex
    ].value;
    var stok = urunStok[urunID];
    if (stok <= 0) {
      alerter.show(lang_stoktaOlmayanUrunuEkleyemezsiniz);
      stop = true;
    }
    if (urunID > 0) {
      secilenUrunArray[secilenUrunArray.length] = urunID;
      secilenAdetArray[secilenAdetArray.length] = $("#adet_" + catID).val();
    }
  }
  if (secilenUrunArray.length > 0 && stop == false) {
    document.getElementById("SistemSepeteEkleDiv").innerHTML =
      '<table><tr><td><img src="images/ajax.gif"></td><td stlye="padding-left:10px;">' +
      lang_lutfenBekleyin +
      "</td></tr></table>";
    //alert(secilenUrunArray.length);
    for (var i = 0; i < secilenUrunArray.length; i++) {
      var url =
        "include/ajaxLib.php?act=teklifEkle&urunID=" +
        secilenUrunArray[i] +
        "&adet=" +
        secilenAdetArray[i];
      //window.open(url);
      if (i < secilenUrunArray.length - 1) {
        $.get(url, function (data) {});
      } else {
        $.get(url, function (data) {
          window.location = siteDizini + "page.php?act=tekliflerim";
        });
      }
    }
    window.location = siteDizini + "page.php?act=tekliflerim";
  }
}

function hizliUrunGoster(urunID) {
  if (isMobile) return goUrun(urunID);
  $.fancybox({
    type: "iframe",
    autoSize: true,
    href: "popup.php?act=urunDetay&urunID=" + urunID,
    afterClose: function () {
      sepetHTMLGuncelle("");
    },
  });
  return false;
}

function quickLogin(name, password) {
  var url =
    "include/ajaxLib.php?act=quickCheckUser&username=" +
    encodeURIComponent(name) +
    "&password=" +
    encodeURIComponent(password);
  $.get(url, function (data) {
    if (data) {
      location.reload(true);
    } else alerter.show(lang_hataliKullaniciVeyaSifre);
  });
  return false;
}

function quickRegister(name, lastname, email, password, gsm, sex, rule) {
  if (!name || !lastname || !email || !password || !gsm || !sex) {
    alerter.show(lang_eksiksizDoldurun);
    return false;
  }
  if (!rule) {
    alerter.show("Lütfen kurallar bölümünü onaylayın.");
    return false;
  }
  var url =
    "include/ajaxLib.php?act=quickRegister&name=" +
    encodeURIComponent(name) +
    "&lastname=" +
    encodeURIComponent(lastname) +
    "&email=" +
    encodeURIComponent(email) +
    "&pass=" +
    encodeURIComponent(password) +
    "&gsm=" +
    encodeURIComponent(gsm) +
    "&sex=" +
    encodeURIComponent(sex);
  $.get(url, function (data) {
    if (data == "ue") alerter.show(lang_epostaDahaOnceAlinmis);
    else {
      quickLogin(email, password);
    }
  });
  return false;
}

function quickContact(
  name,
  nameValidate,
  email,
  emailValidate,
  tel,
  telValidate,
  msg,
  msgValidate
) {
  var stop = false;
  if (nameValidate && !name) stop = true;
  else if (emailValidate && !email) stop = true;
  else if (telValidate && !tel) stop = true;
  else if (msgValidate && !msg) stop = true;
  if (stop) alerter.show(lang_eksiksizDoldurun);
  else if (emailValidate && !Validate_Email_Address(email))
    alerter.show(lang_hataliEposta);
  else {
    $.ajax({
      url:
        "include/ajaxLib.php?act=quickContact&urunID=0&namelastname=" +
        encodeURIComponent(name) +
        "&ceptel=" +
        encodeURIComponent($("#tel").val()) +
        "&email=" +
        encodeURIComponent($("#xemail").val()),
      success: function (data) {
        alerter.show(lang_iletisimOK);
      },
    });
  }
  return false;
}

function teklifSepetEkle() {
  $(".teklifInfoTable").html('<center><img src="images/ajax.gif"></center>');
  $(".teklifUrunID").each(function () {
    var url =
      "include/ajaxLib.php?act=sepetEkle&urunID=" +
      encodeURIComponent($(this).text()) +
      "&adet=" +
      $(this).parent().find(".adet").val();
    $.get(url, function (data) {});
  });
  setTimeout(function () {
    window.location = siteDizini + "page.php?act=sepet";
  }, 3000);
}

function sistemSepeteEkle() {
  var stop = false;
  var secilenUrunArray = new Array();
  var secilenAdetArray = new Array();
  for (var i = 1; i <= toplamkategori; i++) {
    catID = catNum[i];
    var urunID = $("#urunSelected_" + catID).val();
    var stok = urunStok[urunID];
    if (stok <= 0) {
      alerter.show(lang_stoktaOlmayanUrunuEkleyemezsiniz);
      stop = true;
    }
    if (urunID > 0) {
      secilenUrunArray[secilenUrunArray.length] = urunID;
      secilenAdetArray[secilenAdetArray.length] = $("#adet_" + catID).val();
    }
  }
  if (secilenUrunArray.length > 0 && stop == false) {
    document.getElementById("SistemSepeteEkleDiv").innerHTML =
      '<table><tr><td><img src="images/ajax.gif"></td><td stlye="padding-left:10px;">' +
      lang_lutfenBekleyin +
      "</td></tr></table>";
    //alert(secilenUrunArray.length);
    for (var i = 0; i < secilenUrunArray.length; i++) {
      var url =
        "include/ajaxLib.php?act=sepetEkle&urunID=" +
        encodeURIComponent(secilenUrunArray[i]) +
        "&adet=" +
        encodeURIComponent(secilenAdetArray[i]);
      if (i < secilenUrunArray.length - 1) {
        $.get(url, function (data) {});
      } else {
        $.get(url, function (data) {
          setTimeout(function () {
            window.location.href = siteDizini + "page.php?act=sepet";
          }, 2000);
        });
      }
    }
    // window.location = 'page.php?act=sepet';
  }
}

function updateSubMarka(sID) {
  document.getElementById("opt3").options.length = 1;
  document.getElementById("opt3").options[0].text = lang_lutfenBekleyin;
  var pars = "act=topSubMarka&catID=" + sID;
  $.ajax({
    url: "include/ajaxLib.php?act=topSubMarka&catID=" + sID,
    success: function (data) {
      upOptions("opt3", data);
    },
  });
  topCatID =
    document.getElementById("opt2").selectedIndex >= 0
      ? document.getElementById("opt2").options[
          document.getElementById("opt2").selectedIndex
        ].value
      : document.getElementById("opt1").options[
          document.getElementById("opt1").selectedIndex
        ].value;
}

function upOptions(id, result) {
  document.getElementById(id).options.length = 0;
  var optsArray = result.split("||");
  for (var i = 0; i < optsArray.length; i++) {
    var optDataArray = optsArray[i].split("$$");
    optDataArray[1] = optDataArray[1].replace("&#39;", "'");
    document.getElementById(id).options[
      document.getElementById(id).options.length
    ] = new Option(optDataArray[1], optDataArray[0]);
  }
}

// Üst Kategori Listesi Fonksiyonları

var toplamkdvdahil = 0;
var toplamkdvharic = 0;
var toplamkdv = 0;

var KDVHaricArray = new Array();

function updateToplam() {
  var is = document.getElementsByTagName("input");
  toplamkdvdahil = 0;
  toplamkdvharic = 0;
  toplamkdv = 0;
  for (var i = 0; i < is.length; i++) {
    if (is[i].id.indexOf("fiyat_") == 0) {
      var realID = is[i].id.replace("fiyat_", "");
      toplamkdvdahil += parseFloat(is[i].value);
      if (KDVHaricArray[realID])
        toplamkdvharic += parseFloat(KDVHaricArray[realID]);
    }
  }
  toplamkdv = toplamkdvdahil - toplamkdvharic;
  document.getElementById("kdvdahil").innerHTML = moneyFormat(toplamkdvdahil);
  //document.getElementById('kdvharic').innerHTML = moneyFormat(toplamkdvharic);
  document.getElementById("toplamytl").innerHTML = moneyFormat(toplamkdvdahil);
  //document.getElementById('toplamkdv').innerHTML = moneyFormat(toplamkdv);
  document.getElementById("dolar").innerHTML = moneyFormat(
    toplamkdvdahil / dolar
  );
  document.getElementById("euro").innerHTML = moneyFormat(
    toplamkdvdahil / euro
  );
  if (document.getElementById("havaleile"))
    document.getElementById("havaleile").innerHTML = moneyFormat(
      toplamkdvdahil - toplamkdvdahil * havaleindirim
    );
}

function updateKategori(urunID) {
  var url = "include/ajaxLib.php";
  var catID = 0;
  var data = "";
  var myAjax = new Array();
  for (var i = 2; i <= updatekategori; i++) {
    catID = catNum[i];
    var pars =
      "act=updateKategori&urunID=" +
      urunID +
      "&catID=" +
      catID +
      "&randID=" +
      Math.floor(Math.random() * 1000000);
    var target = "catNum_" + i;
    if (urunID > 0) {
      pcTopLoading(i);
      $("#" + target).load("include/ajaxLib.php?" + pars);
    }
    up("adet_" + catID, 0);
    up("fiyat_" + catID, 0);
    document.getElementById("detail_href_" + catID).href = "#";
    document.getElementById("detail_href_" + catID).target = "_self";
    ch("stok_" + catID, "stok_def_" + catID);
    KDVHaricArray[catID] = 0;
  }

  updateToplam();
}

function pcTopLoading(i) {
  document.getElementById("catNum_" + i).innerHTML =
    '<img src="images/ajax.gif"> ';
}

function pcTopLoaded(response, i) {
  document.getElementById("catNum_" + i).innerHTML = response.responseText;
}

function updateFiyat(urunID, catID) {
  var fiyat = urunFiyat[urunID];
  var stok = urunStok[urunID];
  up("adet_" + catID, 1);
  if (fiyat > 0) up("fiyat_" + catID, moneyFormat(fiyat));
  if (urunID > 0) {
    if (stok > 0) ch("stok_" + catID, "stok_var_" + catID);
    else {
      ch("stok_" + catID, "stok_yok_" + catID);
      up("adet_" + catID, 0);
      up("fiyat_" + catID, 0);
    }
  } else {
    ch("stok_" + catID, "stok_def_" + catID);
    up("adet_" + catID, 0);
    up("fiyat_" + catID, 0);
  }
  if (stok > 0) KDVHaricArray[catID] = urunKDVHaricFiyat[urunID];
  document.getElementById("detail_href_" + catID).href =
    urunID > 0 ? "page.php?act=urunDetay&urunID=" + urunID : "#";
  document.getElementById("detail_href_" + catID).target =
    urunID > 0 ? "_blank" : "_self";
  updateToplam();
}

function updateAdet(v, catID) {
  var xID = "#urunSelected_" + catID;
  var urunID = $(xID).val();
  if (v == 0 || !v) KDVHaricArray[catID] = 0;
  else KDVHaricArray[catID] = urunKDVHaricFiyat[urunID] * v;
  var urunID = document.getElementById("urunSelected_" + catID).options[
    document.getElementById("urunSelected_" + catID).selectedIndex
  ].value;
  var fiyat = urunFiyat[urunID];
  var stok = urunStok[urunID];
  if (!isInt(v)) {
    alerter.show(lutfenSadeceRakkamKullanin);
    v = urunID > 0 && stok > 0 ? 1 : 0;
    up("adet_" + catID, v);
  } else if (v > stok) {
    alerter.show(lang_stoktlarimizdaYok);
    up("adet_" + catID, stok);
    v = stok;
  }
  if (urunID > 0) up("fiyat_" + catID, moneyFormat(fiyat * v));
  updateToplam();
}

function ShowDetailPic(catID) {
  var urunID = document.getElementById("urunSelected_" + catID).options[
    document.getElementById("urunSelected_" + catID).selectedIndex
  ].value;
  document.getElementById("detail_div_" + catID).innerHTML =
    '<img src="include/resize.php?path=images/urunler/' +
    urunResim[urunID] +
    '&width=500&height=100">';
  if (urunResim[urunID])
    document.getElementById("detail_div_" + catID).style.display = "block";
}
// PC Toplama Fonksiyonları
function moneyFormat(number) {
  var decimalplaces = 2;
  var decimalcharacter = ".";
  var thousandseparater = ",";
  number = parseFloat(number);
  var sign = number < 0 ? "-" : "";
  var formatted = new String(number.toFixed(decimalplaces));
  if (decimalcharacter.length && decimalcharacter != ".") {
    formatted = formatted.replace(/\./, decimalcharacter);
  }
  var integer = "";
  var fraction = "";
  var strnumber = new String(formatted);
  var dotpos = decimalcharacter.length
    ? strnumber.indexOf(decimalcharacter)
    : -1;
  if (dotpos > -1) {
    if (dotpos) {
      integer = strnumber.substr(0, dotpos);
    }
    fraction = strnumber.substr(dotpos + 1);
  } else {
    integer = strnumber;
  }
  if (integer) {
    integer = String(Math.abs(integer));
  }
  while (fraction.length < decimalplaces) {
    fraction += "0";
  }
  temparray = new Array();
  while (integer.length > 3) {
    temparray.unshift(integer.substr(-3));
    integer = integer.substr(0, integer.length - 3);
  }
  temparray.unshift(integer);
  integer = temparray.join(thousandseparater);
  var out = sign + integer + decimalcharacter + fraction;

  if(kurusgizle)
    out = out.replace('.00','');
  return out;
}

function moneyFormat2(V) {
  var intPart, decPart;
  ret = V * 100;
  ret = Math.round(ret);
  ret = V < 0.1 ? "0" + ret : ret;
  ret = V < 1 ? "0" + ret : "" + ret;
  intPart = ret.substring(0, ret.length - 2);
  decPart = ret.substring(ret.length - 2);
  ret = intPart + "." + decPart;
  if (ret.indexOf("-") >= 0) ret = ret.replace("00", "");
  return ret;
}

function pause(numberMillis) {
  var now = new Date();
  var exitTime = now.getTime() + numberMillis;
  while (true) {
    now = new Date();
    if (now.getTime() > exitTime) return;
  }
}

function isInt(x) {
  var y = parseInt(x);
  if (isNaN(y)) return false;
  return x == y && x.toString() == y.toString();
}

function gv(id) {
  if (document.getElementById(id)) return document.getElementById(id).value;
  else alert("DEBUG gv : " + id + " -> NOID.");
}

function up(id, v) {
  if (document.getElementById(id)) document.getElementById(id).value = v;
  else alert("DEBUG up : " + id + " -> NOID.");
}

function ch(oldid, newid) {
  if (!document.getElementById(oldid))
    alert("DEBUG ch : " + oldid + " -> NOID.");
  if (!document.getElementById(newid))
    alert("DEBUG ch : " + newid + " -> NOID.");
  document.getElementById(oldid).innerHTML = document.getElementById(
    newid
  ).innerHTML;
}

function openTab(id) {
  if (
    $("#fancyTabContainer").html() != null &&
    $("#fancyTabContainer").html() != ""
  ) {
    id++;
    $("#fancyTabContainer .tabs1 li:eq(" + id + ")").click();
    return;
  }
  //if (lastTabID == id) return;
  var cont = false;
  {
    if (lastTabID) $("#tabData" + lastTabID).hide("fast");
    $("#tabData" + id).show("fast");
    $("#tabData" + id + " .imgCaptchaRefresh").click();
    lastTabID = id;
    cont = true;
  }
  for (var i = 1; i <= 10; i++) {
    if (document.getElementById("option" + i)) {
      document.getElementById("option" + i).style.backgroundPosition = "0% 0px";
      document
        .getElementById("option" + i)
        .getElementsByTagName("span")[0].style.backgroundPosition = "100% 0px";
    }
  }
  if (cont && document.getElementById("option" + id) != null) {
    document.getElementById("option" + id).style.backgroundPosition =
      "0% -42px";
    document
      .getElementById("option" + id)
      .getElementsByTagName("span")[0].style.backgroundPosition = "100% -42px";
  }
}

function flash(w, h, u, t) {
  document.write(
    "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='" +
      w +
      "' height='" +
      h +
      "'><param name='movie' value='" +
      u +
      "'><param name='quality' value='high'>"
  );
  document.write("<param name='wmode' value='transparent'>");
  document.write(
    "<embed src='" +
      u +
      "' quality='high' wmode='transparent' type='application/x-shockwave-flash' width='" +
      w +
      "' height='" +
      h +
      "'></embed></object>"
  );
}

function Validate_Email_Address(email) {
  $("#gf_email").val($("#gf_email").val().replace(/ /g, ""));
  email.replace(/ /g, "");
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function trFix(string) {
  //string = string.replace(/y/g,'ı');
  //string = string.replace(/?/g,'ş');
  //string = string.replace(/?/g,'ğ');
  return string;
}

function sssOpen(ID) {
  if (lastSSSID) {
    $("#sss_cevap_" + lastSSSID).slideUp("fast");
    $("#sss_image_" + lastSSSID).attr({ src: "images/sss_close.gif" });
  }
  if (lastSSSID != ID) {
    $("#sss_cevap_" + ID).slideDown("fast");
    $("#sss_image_" + ID).attr({ src: "images/sss_open.gif" });
    lastSSSID = ID;
  } else lastSSSID = 0;
}

function fc(obj) {
  obj.innerHTML =
    obj.innerHTML + '<input type="submit" style="display:none" id="sb">';
  document.getElementById("sb").click();
}

function pencereAc(url, en, boy) {
  var y = window.top.outerHeight / 2 + window.top.screenY - boy / 2;
  var x = window.top.outerWidth / 2 + window.top.screenX - en / 2;
  window
    .open(
      url,
      "shopphp",
      "height=" +
        boy +
        ",width=" +
        en +
        ",status=no,toolbar=no,menubar=no,location=no,scrollbars=1, top=" +
        y +
        ", left=" +
        x
    )
    .focus();
}

function is_int(input) {
  return typeof input == "number" && parseInt(input) == input;
}

function bookmark() {
  if (window.sidebar) {
    // Mozilla Firefox Bookmark
    window.sidebar.addPanel(location.href, document.title, "");
  } else if (window.external) {
    // IE Favorite
    window.external.AddFavorite(location.href, document.title);
  } else if (window.opera && window.print) {
    // Opera Hotlist
    this.title = document.title;
    return true;
  }
}

function liftOff() {
  window.location.reload();
}

function errorAlert(str) {
  swal({
    title: "Hata!",
    text: str,
    icon: "error",
    button: lang_OK,
  });
}

function ugFiyat(lineID) {
  swal("Ürün Yeni Fiyatını Girin:", {
    content: "input",
    button: "Güncelle",
  }).then(function (value) {
    $.get(
      "include/ajaxLib.php?act=userGroupFiyat&lineID=" +
        lineID +
        "&fiyat=" +
        value,
      function (data) {
        if (data == "err") {
          swal({
            title: "Hata!",
            text: "Fiyat güncellenmedi.",
            icon: "error",
            button: lang_OK,
          });
        } else {
          sepetHTMLGuncelle(data);
          swal({
            title: "",
            text: "Fiyat güncellendi.",
            icon: "success",
            button: lang_OK,
          });
        }
      }
    );
  });
}
