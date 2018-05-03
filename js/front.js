
$(document).ready(function () {
    $('.data').mask('00/00/0000');
    $('.fone').mask('0000-0000');
    $('.cel').mask('00000-0000');
    $('.cep').mask('00000-000');
    $('.codigo').mask('000');


    // ------------------------------------------------------- //
    // form usuario
    // ------------------------------------------------------ //
    $('#form-usuario').ready(function () {
        var tipo = $('#tipo');
        var tipo_aluno_ra = $('#tipo_aluno_ra');
        var tipo_aluno_curso = $('#tipo_aluno_curso');
        var ra = $('#ra')
        var curso = $('#curso');
        if (tipo.val() != 1){
            tipo_aluno_ra.hide();
            tipo_aluno_curso.hide();
        }
        tipo.change(function () {
            if (tipo.val() == 1) {
                tipo_aluno_ra.show();
                tipo_aluno_curso.show();
                ra.attr("required", true);
                curso.attr("required", true);
            } else {
                tipo_aluno_ra.hide();
                tipo_aluno_curso.hide();
                ra.attr("required", false);
                curso.attr("required", false);
            }
        });
    });

    // ------------------------------------------------------- //
    // Usuario validar
    // ------------------------------------------------------ //
    $('#form-usuario').validate({
        messages: {
            tipo: {
                required: "Por favor, escolha o TIPO DE CADASTRO"
            },
            ra: {
                required: "Por favor, digite seu RA"
                number: "Por favor, o RA só aceita números"
            },
            curso: {
                required: "Por favor, escolha o CURSO"
            },
            nome: {
                required: "Por favor, digite seu NOME"
            },
            email: {
                required: "Por favor, digite seu E-MAIL"
            },
            senha: {
                required: "Por favor, digite sua SENHA",
                minlength: "A SENHA deve ter pelo menos 5 caracteres"
            },
            senha_conf: {
                required: "Por favor, confirma sua SENHA",
                minlength: "A SENHA deve ter pelo menos 5 caracteres",
                equalTo: "A SENHA não confere"
            },
            senha1_conf: {
                equalTo: "A SENHA não confere"
            }
        },
        rules: {
            ra:
                number: true
            senha: {
                required: true,
                minlength: 5
            },
            senha_conf: {
                required: true,
                minlength: 5,
                equalTo: "#senha"
            },
            senha1_conf: {
                equalTo: "#senha1"
            }
        }
    });
    
    // ------------------------------------------------------- //
    // Produto validar
    // ------------------------------------------------------ //
    $('#form-produto').validate({
        messages: {
            categ: {
                required: "Por favor, escolha uma CATEGORIA"
            },
            produto: {
                required: "Por favor, digite o NOME DO PRODUTO"
            },
            valor: {
                required: "Por favor, digite o VALOR DO PRODUTO"
            },
            descricao: {
                required: "Por favor, digite a DESCRIÇÃO DO PRODUTO"
            }
        }
    });

    // ------------------------------------------------------- //
    // Transition Placeholders
    // ------------------------------------------------------ //
    $('.form-active').ready(function () {
        if ($('input.input-material').val() !== '') {
            $('input.input-material').siblings('.label-material').addClass('active');
        }
    });
    $('input.input-material').on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    $('input.input-material').on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });

    // ------------------------------------------------------- //
    // Upload
    // ------------------------------------------------------ //
    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function (event, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }

    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {
        readURL(this);
    });
});

function validar_alterar(formulario) {
    document.getElementById(formulario).submit()
}
function validar_excluir(msg, url) {
    if (confirm(msg))
        location.href = url
}
function validar_limpar(msg, formulario) {
    if (confirm(msg))
        document.getElementById(formulario).submit()
}
function calc_valor(op, valor) {
    total = document.getElementById('total').value;
    total = parseFloat(total.replace(',', '.'));
    if (op)
        total += parseFloat(valor);
    else
        total -= parseFloat(valor);
    total = total.toFixed(2);
    total = total.replace('.', ',');
    document.getElementById('total').value = total;
}