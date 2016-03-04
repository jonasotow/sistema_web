    $(document).ready(function() {
        $("select[name=idestado]").change(function() {
            idestado = $('select[name=idestado]').val();
            $.post(base_url + "fletes/fletes_oridest/llenar_select", {
                idestado : idestado
            }, function(data) {
                $("select[name=idciudadorigen]").html(data);
                $("select[name=idciudad]").html(data);
            });
        })
        $("select[id=idestado]").change(function() {
            idestado = $('select[id=idestado]').val();
            $.post(base_url + "fletes/fletes_oridest/llenar_select", {
                idestado : idestado
            }, function(data) { 
                $("select[id=idciudad]").html(data);
            });
        })
        $("select[name=idestado2]").change(function() {
            idestado2 = $('select[name=idestado2]').val();
            $.post(base_url + "fletes/fletes_oridest/llenar_select", {
                idestado2 : idestado2
            }, function(data) {
                $("select[name=idciudaddestino]").html(data);
            });
        })
    });

    function control(f){
        var ext=['csv'];
        var v=f.value.split('.').pop().toLowerCase();
        for(var i=0,n;n=ext[i];i++){
            if(n.toLowerCase()==v)
            return
        }
        var t=f.cloneNode(true);
        t.value='';
        f.parentNode.replaceChild(t,f);
        alert('extensión no válida');
    }