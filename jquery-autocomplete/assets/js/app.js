$('input[name="cpf"]').autocomplete({
    minLength: 3,
    delay: 300,
    source: function (request, response) {
        $.ajax({
            url: 'clientes/get-data',
            type: 'post',
            dataType: "JSON",
            data: request,

            success: function (data) {
                let a = [];
                for (let result of data) {
                    let cpf = cpfFormat(result.cpf);
                    a.push({
                        label: cpf + '<br><small class="text-muted">' + result.nome + '</small>',
                        value: cpf
                    });
                }
                response(a);
            }
        });
    }
});

function cpfFormat(cpf) {
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}
