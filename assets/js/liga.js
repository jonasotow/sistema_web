/*
 *  Project: LIGA.js
 *  Description: Plugin que integra una serie de funciones y métodos para facilitar la programación de aplicaciones web.
 *  Author: Mtro. Oscar Galileo García García
 *  License: BSD-3
 */
;(function ( $, window, document, undefined ) {
    var pluginName = "liga";

    // Funciones auxiliares
    // DIV que bloquea otros elementos con los alert y preguntas
    function bloqueador() {
        return $('<div />').addClass('bloquea').css(
            {width   : '105%',
            height   : '105%',
            margin   : '-10px',
            position : 'fixed',
            'z-index': 1000,
            opacity  : '0.6',
            filter   : 'alpha(opacity = 60)'}
        ).click(function() {
            var btns = $('.cerrarMsjAlerta');
            if (btns.size() > 1) {
                $('.btn2').click();
            } else {
                btns.click();
            }
        }).attr('onselectstart', 'return false;').attr('onmousedown', 'return false;');
    }
    // Centra un alerta y pregunta
    function centrar(ven) {
        var iz    = $(window).width()/2;
        var ar    = $(window).height()/2;
        var msjIz = ven.outerWidth()/2;
        var msjAr = ven.outerHeight()/2;
        if ((msjIz*2)>((iz*2)*0.5)) {
            ven.css({position:'fixed', left:5, top :5, right:5, 'z-index': 1500});
        } else {
            ven.css({position:'fixed', left:iz-msjIz, top :(ar-msjAr)*0.4, 'z-index': 1500});
        }
    }
    
    // Constructor
    function Plugin( method, element, options ) {
        this.method  = method;
        this.element = element;
        this.options = options;
        this._name   = pluginName;
        //this.init();
        if (this[method]) {
            return this[method](this.element, this.options);
        }
    }

    Plugin.prototype = {

        /*init: function() {
            // Place initialization logic here
            // You already have access to the DOM element and
            // the options via the instance, e.g. this.element
            // and this.options
            // you can add more functions like the one below and
            // call them like so: this.yourOtherFunction(this.element, this.options).
        },//*/
        alerta : function(el, options) {
            if (typeof options !== 'object') options = {msj: String(options)};
            var settings = $.extend( {
                msj : ' ',
                tit : '¡Atención!',
                'class' : 'alerta',
                vel : 'fast',
                btn : 'Cerrar',
                fijo: true,
                func: function () {}
            }, options);
            // Capa para bloquear otros elementos de la página
            var div = bloqueador();
            $('body').addClass('sin-scroll');
            $('body').prepend(div);
            // Cuadro de título de la alerta
            var tit = $('<div />').addClass('titAlerta ui-widget-header').html('<span class="ui-icon ui-icon-notice" style="float: left; margin-right: .3em;"></span>'+settings['tit']);
            // Botón para cerrar la ventana de alerta
            var btn = $('<button />').addClass('cerrarMsjAlerta btn1').html(settings['btn']).click(function (e) {
                $(this).parent().slideUp(settings['vel'], function () {
                    $('body').removeClass('sin-scroll').removeAttr('unselectable').removeAttr('onselectstart').removeAttr('onmousedown');
                    settings['func']();
                    div.remove();
                    $(this).remove();
                });
                e.preventDefault();
            });
            // Mensaje del alerta
            var msj = $('<div />').addClass('contAlerta').html(settings['msj']);
            // Armamos el rompecabezas en la ventana
            var ven = $('<div />').addClass(settings['class']+' ui-widget-content').prepend(tit, msj, btn);
            $('body').prepend(ven);
            // Desbloqueo la selección de texto en la ventana
            $('.contAlerta').css('user-select', 'text');
            // Centramos la alerta en la ventana
            centrar(ven);
            // Hacemos que la ventana aparezca
            ven.slideDown(settings['vel'], function () {
                btn.focus();
                // Se centra otra vez por si varió el tamaño
                centrar(ven);
                $(window).resize(function() {
                    centrar(ven);
                });
                // Si está disponible JQuery UI Draggable se podrá mover
                if ($.isFunction( $.fn.draggable )) {
                    ven.draggable({handle:'.titAlerta', scroll:false, revert: settings['fijo']});
                    $('.titAlerta', ven).css({cursor:'move'}).disableSelection();
                }
            });
            return ven;
        },
        pregunta : function(el, options) {
            if (typeof options !== 'object') options = {msj: String(options)};
            var settings = $.extend( {
                msj : ' ',
                tit : 'Confirmación',
                'class' : 'alerta',
                vel : 'fast',
                btnS: 'Si ',
                btnN: 'No',
                fijo: true,
                funcS: function () {},
                funcN: function () {}
            }, options);
            // Capa para bloquear otros elementos de la página
            var div = bloqueador();
            $('body').addClass('sin-scroll');
            $('body').prepend(div);
            // Cuadro de título de la pregunta
            var tit = $('<div />').addClass('titAlerta ui-widget-header').html('<i class="fa fa-info-circle"></i> '+settings['tit']);
            // Botón para responde "sí"
            var btS = $('<button />').addClass('btn btn-primary').html(settings['btnS']).click(function (e) {
                settings['funcS']();
                $(this).parent().slideUp(settings['vel'], function () {
                    $('body').removeClass('sin-scroll');
                    div.remove();
                    $(this).remove();
                });
                e.preventDefault();
            });
            var btN = $('<button />').addClass('btn btn-danger').html(settings['btnN']).click(function (e) {
                settings['funcN']();
                $(this).parent().slideUp(settings['vel'], function () {
                    $('body').removeClass('sin-scroll');
                    div.remove();
                    $(this).remove();
                });
                e.preventDefault();
            });
            // Texto de la pregunta
            var msj = $('<div />').addClass('contAlerta').html(settings['msj']);
            // Armamos el rompecabezas en la ventana
            var ven = $('<div />').addClass(settings['class']+' ui-widget-content').prepend(tit, msj, btS, btN);
            $('body').prepend(ven);
            // Desbloqueo la selección de texto en la ventana
            $('.contAlerta').css('user-select', 'text');
            // Centramos la alerta en la ventana
            centrar(ven);
            // Hacemos que la ventana aparezca
            ven.slideDown(settings['vel'], function () {
                btN.focus();
                $(window).resize(function() {
                    centrar(ven);
                });
                // Si está disponible JQuery UI Draggable se podrá mover
                if ($.isFunction( $.fn.draggable )) {
                    ven.draggable({handle:'.titAlerta', scroll:false, revert: settings['fijo']});
                    $('.titAlerta', ven).css({cursor:'move'}).disableSelection();
                }
            });
            return ven;
        },
        notificacion :  function(el, options) {
            if (typeof options !== 'object') options = {msj: String(options)};
            var settings = $.extend( {
                msj : ' ',
                tit : 'Notificación',
                img : 'http://4.bp.blogspot.com/-6hx-qdNb8XU/T4nW4Q-Qf4I/AAAAAAAAAWs/IY0z6IPpbyQ/s200/LIGA.PNG',
                seg : 10,
                alt : 'body',
                func: function () {},
                funClic: function () {}
            }, options);
            // Si las notificaciones no están disponibles se muestran alertas
            if(!('Notification' in window) && !window.webkitNotifications) {
                settings['msj'] = '<img src="'+settings['img']+'" width="35" height="35" style="float: left;" /> '+settings['msj'];
                return $(settings['alt']).liga('mensaje', settings);
            }
            var per = ('Notification' in window) ? Notification.permission : window.webkitNotifications.checkPermission();
            if (per == 2 && per == 'denied') {
                settings['msj'] = '<img src="'+settings['img']+'" width="35" height="35" style="float: left;" /> '+settings['msj'];
                return $(settings['alt']).liga('mensaje', settings);
            }
            // Solicita el permiso y lanza la primera notificación
            if(per > 0 && per != 'default') {
                if ('Notification' in window) {
                    Notification.requestPermission(function() {
                        return $.liga('notificacion', settings);
                    });
                } else {
                    window.webkitNotifications.requestPermission(function() {
                        return $.liga('notificacion', settings);
                    });
                }
            } else {
                var notif;
                if ('Notification' in window) {
                    notif = new Notification(settings['tit'], {body: settings['msj'], icon: settings['img']});
                    notif.onerror = function() {
                        $(settings['alt']).liga('mensaje', settings);
                    };
                    if(settings['seg']) {
                        setTimeout(function() {
                            notif.close();
                        }, settings['seg']*1000);
                    }
                } else {
                    notif = window.webkitNotifications.createNotification(settings['img'], settings['tit'], settings['msj']);
                    notif.show();
                    if(settings['seg']) {
                        setTimeout(function() {
                            notif.cancel();
                        }, settings['seg']*1000);
                    }
                }
                notif.onclose = settings['func'];
                notif.onclick = settings['funClic'];
            }
            return notif;
        },
        mensaje : function(el, options) {
            if (typeof options !== 'object') options = {msj: String(options)};
            var settings = $.extend( {
                msj : ' ',
                tit : 'Mensaje',
                'class' : 'msj1 ui-state-highlight',
                vel : 'fast',
                seg : 10,
                btn : '&nbsp;X&nbsp;',
                conservar: true,
                func: function () {}
            }, options);
            // Botón de cerrar
            var btn = '';
            if (settings['btn']) {
                btn = $('<button />').addClass('cerrarMsj').html(settings['btn']).click(function(e) {
                    $(this).parent().slideUp(settings['vel'], function() {
                        settings['func']();
                        $(this).remove();
                    });
                    e.preventDefault();
                }).attr('title', 'Cerrar mensaje');
            }
            // Contenedor del mensaje
            var cont = $('<div />').addClass(settings['class']+' ui-widget-content')
                                   .attr('title', settings['tit']).css({display:'none'})
                                   .append(btn, settings['msj']);
            // Si es body colocarlo en un DIV flotante (crearlo si no existe)
            var $el = $(el);
            if($el.context.tagName === 'BODY') {
                var div = $('#LIGADIVFLOTANTE');
                if (div.length == 0) {
                 div = $('<div />').attr('id', 'LIGADIVFLOTANTE').css({width:'400px',position:'fixed','left':'50%', 'z-index':900});
                 $('body').prepend(div.css({position:'fixed','margin-left':'-200px'}));
                }
                div.prepend(cont);
            } else {
                $el.prepend(cont);
            }
            cont.fadeIn(settings['vel'], function() {
                if (settings['btn']) {
                    btn.focus();
                }
                if (settings['seg']) {
                    var obj = $(this);
                    var idt = setTimeout(function() {
                        obj.fadeOut(settings['vel'], function() {
                            settings['func']();
                            $(this).remove();
                        });
                    }, settings['seg']*1000);
                    if (settings['conservar']) {
                        // Si el ratón pasa por arriba no desaparecerá hasta que oprima cerrar
                        obj.mousemove(function() {
                            clearTimeout(idt);
                        });
                    }
                }
            });
        }
    };

    $[pluginName] = function ( method , options) {
        var t = document.body;
        if (!$.data(t, pluginName)) {
            $.data(t, pluginName, new Plugin( undefined, $, options ));
        }
        return $.data(t, pluginName)[method]( $, options );
    };

    $.fn[pluginName] = function ( method , options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new Plugin( method, this, options ));
            } else {
                $.data(this, pluginName)[method]( this, options );
            }
        });
    };

})( jQuery, window, document );
