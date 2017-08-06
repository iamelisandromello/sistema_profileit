
jQuery(document).ready(function() {

    var ok = "#btnOK";
    var clean = "#btnClean";
    var radio = ":radio";

    window.triggerConfirmUp = function(icon, nome, confirm, btn_true, btn_false, action, idCompetency, level) {
        //CREATE BOX
        btn_false = (btn_false ? "<span class='btn btn-primary btn-lg margin-btm-30 up_confirm_false'>" + btn_false + "</span>" : "");
        $("body").append("<div class='up_confirm'><div class='up_confirm_box'><div class='up_confirm_box_content'><span class='up_confirm_box_content_icon icon-" + icon + " icon-notext'></span>" + confirm + "</div><div class='up_confirm_box_action'><span class='btn btn-primary btn-lg margin-btm-30 up_confirm_true'>" + btn_true + "</span>" + btn_false + "</div></div></div>");

        //SHOW BOX
        $(".up_confirm").fadeIn(200, function () {
            $(".up_confirm_box").animate({"top": "0", "opacity": "1"}, 200);
        }).css("display", "flex");

        //ACTION BOX
        $(".up_confirm_true").click(function (data) {
            confirmRemove();
            action(true, nome, idCompetency, level);
        });

        $(".up_confirm_false").click(function () {
            confirmRemove();
            action(false, nome, idCompetency, level);
        });

        function confirmRemove() {
            $(".up_confirm_box").animate({"top": "100", "opacity": "0"}, 200, function () {
                $(".up_confirm").fadeOut(200, function () {
                    $(this).remove();
                });
            });
        }
    }


    /**
     * <b>triggerConfirm:</b> Gera uma mensagem de confirmação para o usuário antes de executar o trexo de código.
     * @example if(triggerConfirm(params){ Execute; }
     * @param icon Ícone a ser utilizada Ex: [ warning | info | checkmark ]
     * @param confirm Pergunta de confirmação
     * @param btn_true Texto do botão de aceitação
     * @param btn_false Texto do borão de cancelamento
     * @param callback um array com ação a ser executada
     * @param action uma função para determinar a ação do usuário
     */
    //function triggerConfirm(icon, confirm, btn_true, btn_false, action) {
    window.triggerConfirm = function(icon, nome, confirm, btn_true, btn_false, action) {
        //CREATE BOX
        btn_false = (btn_false ? "<span class='btn btn-primary btn-lg margin-btm-30 up_confirm_false'>" + btn_false + "</span>" : "");
        $("body").append("<div class='up_confirm'><div class='up_confirm_box'><div class='up_confirm_box_content'><span class='up_confirm_box_content_icon icon-" + icon + " icon-notext'></span>" + confirm + "</div><div class='up_confirm_box_action'><span class='btn btn-primary btn-lg margin-btm-30 up_confirm_true'>" + btn_true + "</span>" + btn_false + "</div></div></div>");

        //SHOW BOX
        $(".up_confirm").fadeIn(200, function () {
            $(".up_confirm_box").animate({"top": "0", "opacity": "1"}, 200);
        }).css("display", "flex");

        //ACTION BOX
        $(".up_confirm_true").click(function (data) {
            confirmRemove();
            action(true, nome);
        });

        $(".up_confirm_false").click(function () {
            confirmRemove();
            action(false, nome);
        });

        function confirmRemove() {
            $(".up_confirm_box").animate({"top": "100", "opacity": "0"}, 200, function () {
                $(".up_confirm").fadeOut(200, function () {
                    $(this).remove();
                });
            });
        }
    }

    //Executa triggerConfirm com Array e monitora eventos!
    window.upTriggerConfirm = function(data) {
        //Array Action
        var confirmAction = data.confirm.callback;

        //Trigger SHOW
        triggerConfirm(data.confirm.icon, data.confirm.confirm, data.confirm.btn_true, data.confirm.btn_false, function (callback) {
            if (callback === true) {
                //Redirect Action
                if (confirmAction.redirect) {
                    window.location.href = BASE + "/" + confirmAction.redirect;
                }

                //Reload
                if (confirmAction.reload) {
                    window.location.reload();
                }
            }
        });
    }

    /**
     * <b>triggerNotify:</b> Gera uma notificação rápida para o aluno sem travar o fluxo de navegação.
     * @param color cor da modal [ green | blue | red | yellow ]
     * @param icon Ícone a ser utilizada Ex: [ warning | info | checkmark ]
     * @param title Título da nofiticação
     * @param notify Mensagem da notificação
     */
    //function triggerNotify(color, icon, title, notify) {
    window.triggerNotify = function(color, icon, title, notify) {        
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
    //function triggerAlert(color, icon, title, alert) {
    window.triggerAlert = function(color, icon, title, alert) {          
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

    /*$(ok).on('click' , function(){
        triggerAlert('cyan', 'mug', 'Eeei Elisandro, vc terminou seu cadastro com sucesso?', 'Desconecte sua conta, e relaize Login novamente!');
    });*/

});
