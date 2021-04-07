function gravaPlano() {
    var intCodPlano = "";
    if (document.getElementById("cod_plano_pagamento")) {
        intCodPlano = document.getElementById("cod_plano_pagamento").value;
    }

    if (intCodPlano == "") {
        showDialog("É necessário informar o plano de pagamento.", "cod_plano_pagamento");
        if (document.getElementById("cod_plano_pagamento")) {
            document.getElementById("cod_plano_pagamento").focus();
        }
        return;
    }
    incluirNaListaDePlanosSelecionados(intCodPlano);

}

function incluirNaListaDePlanosSelecionados(plano) {
    var elIdPlanosSelecionados = document.getElementById("ids_planos_selecionados");
    if (elIdPlanosSelecionados) {
        if (elIdPlanosSelecionados.value != "")
            elIdPlanosSelecionados.value += ","
        elIdPlanosSelecionados.value += plano;
    }
}

function excluirDaListaDePlanosSelecionados(plano) {
    var elIdPlanosSelecionados = document.getElementById("ids_planos_selecionados");
    if (elIdPlanosSelecionados) {
        var valorAtualizado = "";
        var listaPlanosSelecionados = elIdPlanosSelecionados.value.split(",");
        for(var i=0; i<listaPlanosSelecionados.length;i++) {
            if (listaPlanosSelecionados[i] != plano) {
                if (valorAtualizado != "") {
                    valorAtualizado += ","
                }
                valorAtualizado += listaPlanosSelecionados[i];
            }
        }
        elIdPlanosSelecionados.value = valorAtualizado;
    }

}