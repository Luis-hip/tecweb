$(document).ready(function() {
    function render(res){
        let tpl = '';
        const data = typeof res === 'string' ? JSON.parse(res) : res;
        data.forEach(i => {
            tpl += `
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>${i.name}</h5>
                            <h6>${i.language} | ${i.format}</h6>
                            <p>${i.description}</p>
                        </div>
                        <div class="card-footer">
                            <a href="${i.url}" target="_blank" class="btn btn-primary btn-block">Ver</a>
                        </div>
                    </div>
                </div>`;
        });
        $('#public_resources-container').html(tpl || '<p class="text-center w-100">No hay recursos disponibles.</p>');
    }

    $.get('./backend/resource-list.php', render);
    $('#public-search').keyup(function() {
        $.get($(this).val() ? './backend/resource-search.php' : './backend/resource-list.php', {search: $(this).val()}, render);
    });
});