
function VATMpad(container_id, callback_ref, font_name, font_size,
                   font_color, bg_color, key_color, border_color,
                   show_click, click_font_color, click_bg_color,
                   click_border_color, do_embed, do_gap,random)
{
  return this._construct(container_id, callback_ref, font_name, font_size,
                         font_color, bg_color, key_color, border_color,
                         show_click, click_font_color, click_bg_color,
                         click_border_color, do_embed, do_gap,random);
}


VATMpad.kbArray = [];

VATMpad.prototype = {

  _setup_event: function(elem, eventType, handler)
  {
    return (elem.attachEvent ? elem.attachEvent("on" + eventType, handler) : ((elem.addEventListener) ? elem.addEventListener(eventType, handler, false) : null));
  },

  _start_flash: function(in_el)
  {
    function getColor(str, posOne, posTwo)
    {
      if(/rgb\((\d+),\s(\d+),\s(\d+)\)/.exec(str)) // try to detect Mozilla-style rgb value.
      {
        switch(posOne)
        {
          case 1: return parseInt(RegExp.$1, 10);
          case 2: return parseInt(RegExp.$2, 10);
          case 3: return parseInt(RegExp.$3, 10);
          default: return 0;
        }
      }
      else // standard (#xxxxxx or #xxx) way
        return str.length == 4 ? parseInt(str.substr(posOne, 1) + str.substr(posOne, 1), 16) : parseInt(str.substr(posTwo, 2), 16);
    }

    function getR(color_string)
    { return getColor(color_string, 1, 1); }

    function getG(color_string)
    { return getColor(color_string, 2, 3); }

    function getB(color_string)
    { return getColor(color_string, 3, 5); }

    var el = in_el.time ? in_el : (in_el.company && in_el.company.time ? in_el.company : null);
    if(el)
    {
      el.time = 0;
      clearInterval(el.timer);
    }

    var vkb = this;
    var ftc = vkb.fontcolor, bgc = vkb.keycolor, brc = vkb.bordercolor;

    // Special fixes for simple/dead/modifier keys:

    if(in_el.dead)
      ftc = vkb.deadcolor;

    if(((in_el.innerHTML == "Shift") && vkb.Shift) || ((in_el.innerHTML == "Caps") && vkb.Caps) || ((in_el.innerHTML == "AltGr") && vkb.AltGr))
      bgc = vkb.lic;

    // Extract base color values:
    var fr = getR(ftc), fg = getG(ftc), fb = getB(ftc);
    var kr = getR(bgc), kg = getG(bgc), kb = getB(bgc);
    var br = getR(brc), bg = getG(brc), bb = getB(brc);

    // Extract flash color values:
    var f_r = getR(vkb.cfc), f_g = getG(vkb.cfc), f_b = getB(vkb.cfc);
    var k_r = getR(vkb.cbg), k_g = getG(vkb.cbg), k_b = getB(vkb.cbg);
    var b_r = getR(vkb.cbr), b_g = getG(vkb.cbr), b_b = getB(vkb.cbr);

    var _shift_colors = function()
    {
      function dec2hex(dec)
      {
        var hexChars = "0123456789ABCDEF";
        var a = dec % 16;
        var b = (dec - a) / 16;

        return hexChars.charAt(b) + hexChars.charAt(a) + "";
      }

      in_el.time = !in_el.time ? 10 : (in_el.time - 1);

      function calc_color(start, end)
      { return (end - (in_el.time / 10) * (end - start)); }

      var t_f_r = calc_color(f_r, fr), t_f_g = calc_color(f_g, fg), t_f_b = calc_color(f_b, fb);
      var t_k_r = calc_color(k_r, kr), t_k_g = calc_color(k_g, kg), t_k_b = calc_color(k_b, kb);
      var t_b_r = calc_color(b_r, br), t_b_g = calc_color(b_g, bg), t_b_b = calc_color(b_b, bb);

      in_el.style.color = "#" + dec2hex(t_f_r) + dec2hex(t_f_g) + dec2hex(t_f_b);
      in_el.style.borderColor = "#" + dec2hex(t_b_r) + dec2hex(t_b_g) + dec2hex(t_b_b);
      in_el.style.backgroundColor = "#" + dec2hex(t_k_r) + dec2hex(t_k_g) + dec2hex(t_k_b);

      if(!in_el.time)
      {
        clearInterval(in_el.timer);
        return;
      }
    };

    _shift_colors();

    in_el.timer = window.setInterval(_shift_colors, 50);
  },

  _setup_style: function(obj, top, left, width, height, position, border_color, bg_color, line_height, font_size, font_weight, padding_left, padding_right)
  {
    var os = obj.style;

    if(top)    os.top = top+"px";
    if(left)   os.left = left+"px";
    if(width)  os.width = width;
    if(height) os.height = height;

    if(position) os.position = position;

    if(border_color) os.border = "1px solid " + border_color;
    if(bg_color) os.backgroundColor = bg_color;

    os.textAlign = "center";
	os.zIndex = 1;

    if(line_height) os.lineHeight = line_height;
    if(font_size)   os.fontSize   = font_size;
	
    os.fontFamily = this.fontname;
    os.fontWeight = "bold";

    if(padding_left)  os.paddingLeft  = padding_left;
    if(padding_right) os.paddingRight = padding_right;
  },

  _setup_golge_style: function(obj, top, left, width, height, position, border_color, bg_color, line_height, font_size, font_weight, padding_left, padding_right)
  {
    var os = obj.style;

    if(top)    os.top = top+"px";
    if(left)   os.left = left+"px";
    if(width)  os.width = width;
    if(height) os.height = height;

    if(position) os.position = position;

    if(border_color) os.border = "0px solid " + border_color;
    if(bg_color) os.backgroundColor = bg_color;

    os.textAlign = "center";
	os.zIndex = 0;
	os.background = 'url(images/golge.gif)';
	os.backgroundRepeat = 'repeat-x';

    if(line_height) os.lineHeight = line_height;
    if(font_size)   os.fontSize   = font_size;

    os.fontWeight = font_weight || "bold";

    if(padding_left)  os.paddingLeft  = padding_left;
    if(padding_right) os.paddingRight = padding_right;
  },

  _setup_key: function(parent, id, top, left, width, height, border_color, bg_color, line_height, font_size, font_weight, padding_left, padding_right)
  {
    var _id = this.Cntr.id + id;
    var exists = document.getElementById(_id);

    var key = exists ? exists.parentNode : document.createElement("DIV");
    this._setup_style(key, top, left, width, height, "absolute");

    var key_sub = exists || document.createElement("DIV");
    key.appendChild(key_sub); parent.appendChild(key);
	
    this._setup_style(key_sub, "", "", "", line_height, "relative", border_color, bg_color, line_height, font_size, font_weight, padding_left, padding_right);
	
    key_sub.id = _id;

    if(!exists) this._setup_event(key_sub, 'mousedown', this._generic_callback_proc);

    return key_sub;
  },

  _setup_key_golge: function(parent, id, top, left, width, height, border_color, bg_color, line_height, font_size, font_weight, padding_left, padding_right)
  {
    var _id = this.Cntr.id + id;
    var exists = document.getElementById(_id);

    var key_golge = exists ? exists.parentNode : document.createElement("DIV");
    this._setup_golge_style(key_golge, top, left, width, height, "absolute","","#FF0000");

    var key_sub_golge = exists || document.createElement("DIV");
    key_golge.appendChild(key_sub_golge); parent.appendChild(key_golge);
	
    this._setup_golge_style(key_sub_golge, "", "", "", line_height, "relative", border_color, "#FF0000", line_height, font_size, font_weight, padding_left, padding_right);
	
    key_sub_golge.id = _id;

    if(!exists) this._setup_event(key_sub_golge, 'mousedown', this._generic_callback_proc);

    return key_sub_golge;
  },

  _findX: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetLeft) : 0; },

  _findY: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetTop) : 0; },

  _findW: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetWidth) : 0; },

  _findH: function(obj)
  { return (obj && obj.parentNode) ? parseFloat(obj.parentNode.offsetHeight) : 0; },

  _construct: function(container_id, callback_ref, font_name, font_size, font_color, bg_color, key_color, border_color,
                       show_click, click_font_color, click_bg_color, click_border_color, do_embed, do_gap, random)
  {
    var exists  = (this.Cntr != undefined), ct = exists ? this.Cntr : document.getElementById(container_id);
    var changed = (font_size && (font_size != this.fontsize));

    this._Callback = ((typeof(callback_ref) == "function") && ((callback_ref.length == 1) || (callback_ref.length == 2))) ? callback_ref : (this._Callback || null);

    var ff = font_name || this.fontname || "";
    var fs = font_size || this.fontsize || "14px";

    var fc = font_color   || this.fontcolor   || "#000";
    var bg = bg_color     || this.bgcolor     || "#FFF";
    var kc = key_color    || this.keycolor    || "#FFF";
    var bc = border_color || this.bordercolor || "#777";

    this.cfc = click_font_color   || this.cfc || "#CC3300";
    this.cbg = click_bg_color     || this.cbg || "#FF9966";
    this.cbr = click_border_color || this.cbr || "#CC3300";

    this.sc = (show_click == undefined) ? ((this.sc == undefined) ? false : this.sc) : show_click;
    this.gap = (do_gap != undefined) ? (do_gap ? 3 : -1) : (this.gap || 1);

    this.fontname = ff, this.fontsize = fs, this.fontcolor = fc;
    this.bgcolor = bg,  this.keycolor = kc, this.bordercolor = bc;
	this.random = random;
    if(!exists)
    {
      this.Cntr = ct, this.LastKey = null;

      VATMpad.kbArray[container_id] = this;
    }

    var kb = exists ? ct.childNodes[0] : document.createElement("DIV");

    if(!exists)
    {
      ct.appendChild(kb);
      ct.style.display = "block";
      ct.style.zIndex  = 999;

      if(!do_embed)
      {
        ct.style.position = "relative";

        var initX = 0, initY = 0, ct_ = ct;
        if(ct_.offsetParent)
        {
          while (ct_.offsetParent)
          {
            initX += ct_.offsetLeft;
            initY += ct_.offsetTop;

            ct_ = ct_.offsetParent;
          }
        }
        else if (ct_.x)
        {
          initX += ct_.x;
          initY += ct_.y;
        }

        ct.style.top = "0px", ct.style.left = "0px";
      }
 
      kb.style.position = "absolute";
      kb.style.top      = "-37px", kb.style.left = "200px";
    }

    kb.style.border = "0px solid " + bc;

    var kb_main = exists ? kb.childNodes[0] : document.createElement("DIV"), ks = kb_main.style;
    if(!exists)
    {
      kb.appendChild(kb_main);

      ks.position = "relative";
      ks.width    = "1px";
      ks.cursor   = "default";
    }

    // Disable content selection:
    this._setup_event(kb_main, "selectstart", function(event) { return false; });
    this._setup_event(kb_main, "mousedown",   function(event) { if(event.preventDefault) event.preventDefault(); return false; });

    ks.fontFamily = ff, ks.backgroundColor = bg;

    if(!exists || changed)
    {
      ks.width  = this._create_numpad(container_id, kb_main);
      ks.height = (this._findY(this.LastKey) + this._findH(this.LastKey) + this.gap) + "px";
    }

    return this;
  },

  _create_numpad: function(container_id, parent)
  {
	function rnd(random){
		var str="";
		var num=new Array();
		for(x=0;x<=9;x++){
			if(random == true){
				var randomnumber = Math.floor(Math.random()*(10));
				if(str.indexOf(randomnumber)==-1){
					str=str+randomnumber.toString();
					num[x] = randomnumber;
				} else {
					x--;
				}
			} else{
				num[x] = x;
			}
		}
		return num;	
	}
	
	var randomSayi=rnd(this.random);
    var c = "center", n = "normal", gap = this.gap;
    var fs = this.fontsize, kc = this.keycolor, bc = this.bordercolor;
	
    var mag = parseFloat(fs) / 14.0, cell = Math.floor(25.0 * mag);
    var cp = String(cell) + "px", lh = String(Math.floor(cell - 2.0)) + "px";

    var edge = gap ;
	var gap_golge = 2;
	var edge_golge = 1;

    var kb_pad_7 = this._setup_key(parent, "___pad_7", gap , edge, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_7_golge", gap+gap_golge , edge+edge_golge, cp, cp, bc, kc, lh, fs);
	kb_pad_7.innerHTML = randomSayi[1];

    var edge_1 = this._findX(kb_pad_7) + this._findW(kb_pad_7) + gap;
	
    var kb_pad_8 = this._setup_key(parent, "___pad_8", gap , edge_1, cp, cp, bc, kc, lh, fs);
	this._setup_key_golge(parent, "___pad_8_golge", gap+gap_golge , edge_1+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_8.innerHTML = randomSayi[2];

    var edge_2 = this._findX(kb_pad_8) + this._findW(kb_pad_8) + gap ;

    var kb_pad_9 = this._setup_key(parent, "___pad_9", gap , edge_2, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_9_golge", gap+gap_golge , edge_2+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_9.innerHTML = randomSayi[3];

    var prevH = this._findH(kb_pad_9), edge_Y = (this._findY(kb_pad_9) + prevH + gap) ;

    edge_Y = (this._findY(kb_pad_7) + prevH + gap) ;

    var kb_pad_4 = this._setup_key(parent, "___pad_4", edge_Y, edge, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_4_golge", edge_Y+gap_golge, edge+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_4.innerHTML = randomSayi[4];

    var kb_pad_5 = this._setup_key(parent, "___pad_5", edge_Y, edge_1, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_5_golge", edge_Y+gap_golge, edge_1+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_5.innerHTML = randomSayi[5];

    var kb_pad_6 = this._setup_key(parent, "___pad_6", edge_Y, edge_2, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_6_golge", edge_Y+gap_golge, edge_2+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_6.innerHTML = randomSayi[6];

    edge_Y = (this._findY(kb_pad_4) + prevH + gap) ;

    var kb_pad_1 = this._setup_key(parent, "___pad_1", edge_Y, edge, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_1_golge", edge_Y+gap_golge, edge+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_1.innerHTML = randomSayi[7];

    var kb_pad_2 = this._setup_key(parent, "___pad_2", edge_Y, edge_1, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_2_golge", edge_Y+gap_golge, edge_1+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_2.innerHTML = randomSayi[8];

    var kb_pad_3 = this._setup_key(parent, "___pad_3", edge_Y, edge_2, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_3_golge", edge_Y+gap_golge, edge_2+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_3.innerHTML = randomSayi[9];

    edge_Y = (this._findY(kb_pad_1) + prevH + gap) ;

    var kb_pad_0 = this._setup_key(parent, "___pad_0", edge_Y, edge, cp, cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_0_golge", edge_Y+gap_golge, edge+edge_golge, cp, cp, bc, kc, lh, fs);
    kb_pad_0.innerHTML = randomSayi[0];

    var kb_pad_sil = this._setup_key(parent, "___pad_period", edge_Y, edge_1, String(2 * cell + gap) + "px" , cp, bc, kc, lh, parseFloat(fs) * 0.9, n);
    this._setup_key_golge(parent, "___pad_period_golge", edge_Y+gap_golge, edge_1+edge_golge, String(2 * cell + gap) + "px" , cp, bc, kc, lh, parseFloat(fs) * 0.9, n);
    kb_pad_sil.innerHTML = "Sil";

    edge_Y = (this._findY(kb_pad_0) + prevH + gap) ;

    var kb_pad_karistir = this._setup_key(parent, "___pad_karistir", edge_Y, edge, String(3 * cell + gap +3) + "px" , cp, bc, kc, lh, fs);
    this._setup_key_golge(parent, "___pad_karistir_golge", edge_Y+gap_golge, edge+edge_golge+3, String(3 * cell + gap) + "px" , cp, bc, kc, lh, fs);
    kb_pad_karistir.innerHTML = "Karýþtýr";

    this.LastKey = kb_pad_karistir;

	kb_pad_0.innerHTML = randomSayi[0];
    return String(this._findX(kb_pad_9) + this._findW(kb_pad_9) + gap) ;
  },

  _generic_callback_proc: function(event)
  {
    var e = event || window.event;
    var in_el = e.srcElement || e.target;
    var container_id = in_el.id.substring(0, in_el.id.indexOf("___"));

    var vpad = VATMpad.kbArray[container_id];

    if(vpad.sc) vpad._start_flash(in_el);

    if(vpad._Callback) vpad._Callback(in_el.innerHTML, vpad.Cntr.id);
  },

  SetParameters: function()
  {
    var l = arguments.length;
    if(!l || (l % 2 != 0)) return false;

    var p0, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10;

    while(--l > 0)
    {
      var value = arguments[l];

      switch(arguments[l - 1])
      {
        case "callback":
          p0 = ((typeof(value) == "function") && ((value.length == 1) || (value.length == 2))) ? value : this._Callback;
          break;

        case "font-name":  p1 = value; break;
        case "font-size":  p2 = value; break;
        case "font-color": p3 = value; break;
        case "base-color": p4 = value; break;
        case "key-color":  p5 = value; break;

        case "border-color": p6 = value; break;
        case "show-click":   p7 = value; break;

        case "click-font-color":   p8  = value; break;
        case "click-key-color":    p9 = value; break;
        case "click-border-color": p10 = value; break;

        default: break;
      }

      l -= 1;
    }

    this._construct(this.Cntr.id, p0, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10);

    return true;
  },

  Show: function(value)
  {
    var ct = this.Cntr.style;

    ct.display = ((value == undefined) || (value == true)) ? "block" : ((value == false) ? "none" : ct.display);
  }
};

   // This function retrieves the position (in chars, relative to
   // the start of the text) of the edit cursor (caret), or, if
   // text is selected in the TEXTAREA, the start and end positions
   // of the selection.
   //
   function getCaretPositions(ctrl)
   {
     var CaretPosS = -1, CaretPosE = 0;

     // Mozilla way:
     if(ctrl.selectionStart || (ctrl.selectionStart == '0'))
     {
       CaretPosS = ctrl.selectionStart;
       CaretPosE = ctrl.selectionEnd;

       insertionS = CaretPosS == -1 ? CaretPosE : CaretPosS;
       insertionE = CaretPosE;
     }
     // IE way:
     else if(document.selection && ctrl.createTextRange)
     {
       var start = end = 0;
       try
       {
         start = Math.abs(document.selection.createRange().moveStart("character", -10000000)); // start

         if (start > 0)
         {
           try
           {
             var endReal = Math.abs(ctrl.createTextRange().moveEnd("character", -10000000));

             var r = document.body.createTextRange();
             r.moveToElementText(ctrl);
             var sTest = Math.abs(r.moveStart("character", -10000000));
             var eTest = Math.abs(r.moveEnd("character", -10000000));

             if ((ctrl.tagName.toLowerCase() != 'input') && (eTest - endReal == sTest))
               start -= sTest;
           }
           catch(err) {}
         }
       }
       catch (e) {}

       try
       {
         end = Math.abs(document.selection.createRange().moveEnd("character", -10000000)); // end
         if(end > 0)
         {
           try
           {
             var endReal = Math.abs(ctrl.createTextRange().moveEnd("character", -10000000));

             var r = document.body.createTextRange();
             r.moveToElementText(ctrl);
             var sTest = Math.abs(r.moveStart("character", -10000000));
             var eTest = Math.abs(r.moveEnd("character", -10000000));

             if ((ctrl.tagName.toLowerCase() != 'input') && (eTest - endReal == sTest))
              end -= sTest;
           }
           catch(err) {}
         }
       }
       catch (e) {}

       insertionS = start;
       insertionE = end
     }
   }

   function setRange(ctrl, start, end)
   {
     if(ctrl.setSelectionRange) // Standard way (Mozilla, Opera, ...)
     {
       ctrl.setSelectionRange(start, end);
     }
     else // MS IE
     {
       var range;

       try
       {
         range = ctrl.createTextRange();
       }
       catch(e)
       {
         try
         {
           range = document.body.createTextRange();
           range.moveToElementText(ctrl);
         }
         catch(e)
         {
           range = null;
         }
       }

       if(!range) return;

       range.collapse(true);
       range.moveStart("character", start);
       range.moveEnd("character", end - start);
       range.select();
     }

     insertionS = start;
     insertionE = end;
   }

   function deleteSelection(ctrl)
   {
     if(insertionS == insertionE) return;

     var tmp = (document.selection && !window.opera) ? ctrl.value.replace(/\r/g,"") : ctrl.value;
     ctrl.value = tmp.substring(0, insertionS) + tmp.substring(insertionE, tmp.length);

     setRange(ctrl, insertionS, insertionS);
   }

   function deleteAtCaret(ctrl)
   {
     // if(insertionE < insertionS) insertionE = insertionS;
     if(insertionS != insertionE)
     {
       deleteSelection(ctrl);
       return;
     }

     if(insertionS == insertionE)
       insertionS = insertionS - 1;

     var tmp = (document.selection && !window.opera) ? ctrl.value.replace(/\r/g,"") : ctrl.value;
     ctrl.value = tmp.substring(0, insertionS) + tmp.substring(insertionE, tmp.length);

     setRange(ctrl, insertionS, insertionS);
   }

   // This function inserts text at the caret position:
   //
   function insertAtCaret(ctrl, val)
   {
     if(insertionS != insertionE) deleteSelection(ctrl);

     if(isgecko && document.createEvent && !window.opera)
     {
       var e = document.createEvent("KeyboardEvent");

       if(e.initKeyEvent && ctrl.dispatchEvent)
       {
         e.initKeyEvent("keypress",        // in DOMString typeArg,
                        false,             // in boolean canBubbleArg,
                        true,              // in boolean cancelableArg,
                        null,              // in nsIDOMAbstractView viewArg, specifies UIEvent.view. This value may be null;
                        false,             // in boolean ctrlKeyArg,
                        false,             // in boolean altKeyArg,
                        false,             // in boolean shiftKeyArg,
                        false,             // in boolean metaKeyArg,
                        null,              // key code;
                        val.charCodeAt(0));// char code.

         ctrl.dispatchEvent(e);
       }
     }
     else
     {
       var tmp = (document.selection && !window.opera) ? ctrl.value.replace(/\r/g,"") : ctrl.value;
       ctrl.value = tmp.substring(0, insertionS) + val + tmp.substring(insertionS, tmp.length);
     }

     setRange(ctrl, insertionS + val.length, insertionS + val.length);
   }
   
   
   
   	var opened = false, elem , capraz = null , vkb = null, text = null, insertionS = 0, insertionE = 0, random = false;

   var userstr = navigator.userAgent.toLowerCase();
   var isgecko = (userstr.indexOf('gecko') != -1) && (userstr.indexOf('applewebkit') == -1);

   function numpad_change()
   {
     //document.getElementById("switch").innerHTML = (opened ? "Klavyeyi Göster" : "Klavyeyi Gizle");
     //opened = !opened;

     if(opened && !vkb)
     {
       vkb = new VATMpad("numpad",     // container's id
                         pad_callback, // reference to the callback function
                         "verdana",     // font name ("" == system default)
                         "13px",       // font size in px
                         "#000",       // font color
                         "#FFF",       // keyboard base background color
                         "#FFF",       // keys' background color
                         "#777",       // border color
                         true,         // show key flash on click? (false by default)
                         "#CC3300",    // font color for flash event
                         "#FF9966",    // key background color for flash event
                         "#CC3300",    // key border color for flash event
                         false,        // embed VNumpad into the page?
                         true,		   // use 1-pixel gap between the keys?
                         random);      // rakamlarýn rastgele dönmesini kontrol eder 
	   		random = true;
     }
     else
     	if (vkb!=null){
     		vkb.Show(opened);
     	}
     	text = elem;
   }

   // Advanced callback function:
   //
   function pad_callback(ch)
   {
   	var val = text.value;

     switch(ch)
     {
       case "Karýþtýr":
	   	vkb = null;
	   	opened = true;
	   	numpad_change();
	   break;
	   
       case "Sil":
         if(val.length)
         {
           var span = null;

           if(document.selection)
             span = document.selection.createRange().duplicate();

           if(span && span.text.length > 0)
           {
             span.text = "";
             getCaretPositions(text);
           }
           else
		   	 capraz=text;
             deleteAtCaret(text);
         }
		       
	   	break;

       default:
   
       if(((text.name=="number" || text.name=="kartnumarasi" || text.name=="cardno" ) && text.value.length>15) || ((text.name=="cvc2" || text.name=="cv2") && text.value.length>2)){
       		return;
       }		   	
         insertAtCaret(text, (ch == "Enter" ? (window.opera ? '\r\n' : '\n') : ch));
         capraz = text;
     }
   }
	
   function klavye(durumu,obje){
   		elem=obje
   		opened=durumu;
   		numpad_change();
   }
   document.onclick=function msg(event){
	   	var aktifElement , ell;
		if(navigator.appName == "Netscape"){
			aktifElement=event.explicitOriginalTarget;
		} else {
			aktifElement=document.activeElement;
		}
		
	   	if(capraz != null){
	   		ell = capraz;
	   	} else if(aktifElement != undefined){
	   		ell = aktifElement;
	   	}
	   	
	   	if(ell != undefined){
			if(ell.name == "kart_sifre" || ell.name == "kart_no" || ell.name == "cardno" || ell.id == "number" ){
				klavye(true,ell);
			} else {
				klavye(false,ell);
			}
	   	}
	   	capraz = null;
	}
