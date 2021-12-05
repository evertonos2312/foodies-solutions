$(document).ready(function (){
    $("#btn-adiciona").prop("disabled", true);
    $("#btn-adiciona").prop("value", 'Selecione um tamanho');

});

$("#primeira_metade").on('change', function () {
    var primeira_metade = $(this).val();
    $("#div_tamanho").hide();
    $("#imagemPrimeiroProduto").html('<img class="card-img-top" src="'+app_url+'src/assets/img/pizza_thinking.png" width="200" alt="Escolha o produto" />')
    $("#imagemSegundoProduto").html('<img class="card-img-top" src="'+app_url+'src/assets/img/pizza_thinking.png" width="200" alt="Escolha o produto" />')
    if(primeira_metade) {
        var csrfName = $('#txt_csrfname').attr('name');
        var csrfHash = $('#txt_csrfname').val();
        $.ajax({
            type: 'get',
            url: app_url + 'produto/procurar',
            dataType: 'json',
            data: {
                primeira_metade: primeira_metade,
                categoria_id: categoria_id,
                [csrfName]: csrfHash
            },
            beforeSend: function (data){
                $("#segunda_metade").html('');
            },
            success: function (data) {
                $('#txt_csrfname').val(data.token)
                if(data.status === 'success') {
                    if(data.detail.imagemPrimeiroProduto) {
                        $("#imagemPrimeiroProduto").html('<img class="card-img-top" width="200" src="'+app_url+'uploads/imagens/produtos/'+data.detail.imagemPrimeiroProduto+'" alt="Escolha o produto" />')
                    }
                    if(data.detail.produtos) {
                        $("#segunda_metade").html('<option>Escolha a segunda metade</option');
                        $(data.detail.produtos).each(function () {
                            var option = $('<option/>');
                            option.attr('value', this.id).text(this.nome);
                            $("#segunda_metade").append(option);
                        });
                    }
                } else {
                    $("#segunda_metade").html('<option>Não encontramos outras opções de customização</option');
                }

            },
            error: function () {
                $("#btn-adiciona").prop('disabled', true);
            },
        });
    } else {
        $("#segunda_metade").html('<option>Escolha a primeira metade</option');
    }
});
$("#segunda_metade").on('change', function (){
    var primeiro_produto_id = $("#primeira_metade").val();
    var segundo_produto_id = $(this).val();

    var csrfName = $('#txt_csrfname').attr('name');
    var csrfHash = $('#txt_csrfname').val();
    $("#div_tamanho").hide();
    $("#boxInfoExtras").hide();
    $("#extras").html('');

    $("#imagemSegundoProduto").html('<img class="card-img-top" src="'+app_url+'src/assets/img/pizza_thinking.png" width="200" alt="Escolha o produto" />')
    if(primeiro_produto_id && segundo_produto_id) {
        $.ajax({
            type: 'get',
            url: app_url + 'produto/exibetamanhos',
            dataType: 'json',
            data: {
                primeiro_produto_id: primeiro_produto_id,
                segundo_produto_id: segundo_produto_id,
                [csrfName]: csrfHash
            },
            beforeSend: function () {
                $("#tamanho").html('');
            },
            success: function (data) {
                $('#txt_csrfname').val(data.token)
                if(data.status === 'success') {
                    if(data.detail.imagemSegundoProduto) {
                        $("#imagemSegundoProduto").html('<img class="card-img-top" width="200" src="'+app_url+'uploads/imagens/produtos/'+data.detail.imagemSegundoProduto+'" alt="Escolha o produto" />')
                    }
                    $("#div_tamanho").show();
                    if(data.detail.medidas) {
                        $("#tamanho").html('<option>Escolha o tamanho</option');
                        $(data.detail.medidas).each(function () {
                            var option = $('<option/>');
                            option.attr('value', this.id).text(this.nome);
                            $("#tamanho").append(option);
                        });
                    } else {
                        $("#tamanho").html('<option>Escolha a segunda metade</option');
                    }

                    if(data.detail.extras) {
                        $("#boxInfoExtras").show();
                        $(data.detail.extras).each(function () {
                            var input = "<div class='radio'><label><input type='radio' class='extra' name='extra' data-extra='"+this.id+"' value='"+this.preco+"'>"+this.nome+"</label></div>"
                            $("#extras").append(input);
                        });
                        $(".extra").on('click', function () {
                           var extra_id = $(this).attr('data-extra');
                           $("#extra_id").val(extra_id);
                        });

                    }

                } else {

                }

            },
            error: function () {
                $("#btn-adiciona").prop('disabled', true);
            },
        });
    }

});