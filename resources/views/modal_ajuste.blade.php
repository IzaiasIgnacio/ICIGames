<div class="modal modal_ajuste" id='modal_ajuste'>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Ajuste</p>
        </header>
        <section class="modal-card-body">
            <form id='form_ajuste'>
                <div class="columns">
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">Título</label>
                            <div class="control">
                                <input class="input is-small" type="text" id="titulo_ajuste" placeholder="Título" name='titulo_ajuste'>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">IGDB</label>
                            <div class="control">
                                <input class="input is-small" type='text' name='id_igdb_ajuste' id='id_igdb_ajuste' placeholder="IGDB">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Lançamento</label>
                            <div class="control">
                                <input class="input is-small campo_data" type="text" name='data_lancamento_ajuste' placeholder="Data de Lançamento">
                            </div>
                        </div>
                        <label class="checkbox label">
                        <input type="checkbox" name='completo_ajuste' id='completo_ajuste'> Completo</label>
                    </div>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <div>
                <button class="button is-link btn_salvar_ajuste">Salvar</button>
                <button class="button is-light btn_cancelar">Cancelar</button>
                <label class='label_progresso'></label>
            </div>
            <button class="button is-pulled-right is-danger btn_excluir">Excluir</button>
        </footer>
    </div>
</div>