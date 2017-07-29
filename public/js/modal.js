
jQuery(document).ready(function() {

    var ok = "#btnOK";
    var clean = "#btnClean";
    var radio = ":radio";

    /**
     * <b>triggerNotify:</b> Gera uma notificação rápida para o aluno sem travar o fluxo de navegação.
     * @param color cor da modal [ green | blue | red | yellow ]
     * @param icon Ícone a ser utilizada Ex: [ warning | info | checkmark ]
     * @param title Título da nofiticação
     * @param notify Mensagem da notificação
     */
    function triggerNotify(color, icon, title, notify) {
        if (!$(".up_notify").length) {
            $("body").append("<div class='up_notify'></div>");
        }
        $(".up_notify_box:gt(2)").animate({"left": "100%", "opacity": "0"}, 200, function () {
            $(this).remove();
        });
        $(".up_notify").prepend("<div class='up_notify_box bg_" + color + "'><b class='icon-" + icon + "'>" + title + "</b> " + notify + "</div>");
        $(".up_notify_box").animate({"left": "0", "opacity": "1"}, 200, function () {
            var BoxNofity = $(this);
            setTimeout(function () {
                BoxNofity.animate({"left": "100%", "opacity": "0"}, 200, function () {
                    $(this).remove();
                });
            }, 10 * 1000);
        });

        $(".up_notify_box").click(function (e) {
            var notifyBox = $(this);
            if (e.target === this) {
                notifyBox.fadeOut(function () {
                    $(this).remove();
                });
            }
        });
    }

    //Executa a triggerNotify com Array!
    function upTriggerNotify(data) {
        if (!data.notify.length) {
            triggerNotify(data.notify.color, data.notify.icon, data.notify.title, data.notify.notify);
        } else {
            $.each(data.notify, function (key, value) {
                setTimeout(function () {
                    triggerNotify(value.color, value.icon, value.title, value.notify);
                }, key * 600);
            });
        }
    }

    /**
     * <b>triggerAlert:</b> Gera um alerta resumido para o aluno. Pode ser um erro de login, ou uma tarefa importante executada. <p><b>ATENÇÃO:</b> Essa modal gera overlay e trava o fluxo de navegação!</p>
     * @param color cor da modal [ green | blue | red | yellow ]
     * @param icon Ícone a ser utilizada Ex: [ warning | info | checkmark ]
     * @param title Título do alerta
     * @param alert Mensagem do alerta
     */
    function triggerAlert(color, icon, title, alert) {
        $("body").css("overflow", "hidden").append("<div class='up_alert'><div class='up_alert_box bg_" + color + "'><span class='icon-cross icon-notext up_alert_close'></span><div class='up_alert_box_icon icon-" + icon + "'></div><div class='up_alert_box_content'><p class='title'>" + title + "</p><p>" + alert + "</p></div></div></div>");
        $(".up_alert").fadeIn(200, function () {
            $(".up_alert_box").animate({"top": "0", "opacity": "1"}, 200);

            $(".up_alert_close").click(function () {
                $("body").css("overflow", "auto");

                $(".up_alert_box").animate({"top": "100", "opacity": "0"}, 200, function () {
                    $(".up_alert").fadeOut(200, function () {
                        $(this).remove();
                    });
                });
            });
        }).css("display", "flex");
    }

    //Executa a trigger alert com Array!
    function upTriggerAlert(data) {
        triggerAlert(data.alert.color, data.alert.icon, data.alert.title, data.alert.alert);
    }


    $(clean).on('click' , function(){

        triggerAlert('cyan', 'mug', 'Eeei Elisandro, vc terminou seu cadastro com sucesso?', 'Desconecte sua conta, e relaize Login novamente!');

    });

    $(ok).on('click' , function(){
        triggerNotify('purple', 'bubbles', 'Eeei Elisandro, vai tomar um café?', 'Você desconectou sua conta com sucesso Elisandro então é hora de relaxar, mas volte logo ok?');
    });

});
