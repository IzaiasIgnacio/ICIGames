<div class="modal modal_jogo is-active" id='modal_formulario_jogo'>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Adicionar jogo</p>
            <button class="delete fechar_modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form>
                <div class="columns">
                    <div class="column is-3">
                    <label class="label">Título</label>
                        <div class="field">
                            <div class="control has-icons-right">
                                <input class="input" type="text" id="campo_busca" placeholder="Título">
                                <span class="icon is-small is-right" style='display:none'>
                                    <i class="fas fa-spin fa-circle-notch"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Descrição</label>
                            <div class="control">
                                <textarea class="textarea" placeholder="Descrição"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Nota</label>
                            <div class="control input_nota">
                                <input class="input" type="number" placeholder="Nota" step="0.1">
                            </div>
                        </div>
                        <label class="checkbox label">
                        <input type="checkbox"> Completo</label>
                    </div>
                    <div class="column is-2">
                        <div class="field">
                            <label class="label">Desenvolvedores</label>
                            <div class="control">
                                <label class='dados_igdb'>adnndiaundua nsauiohaidh</label>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Distribuidores</label>
                            <div class="control">
                                <label class='dados_igdb'>adnndiaundua nsauiohaidh</label>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Gênero</label>
                            <div class="control">
                                <label class='dados_igdb'>adnndiaundua nsauiohaidh</label>
                            </div>
                        </div>
                    </div>
                    <div class="column is-3">
                    <label class="label">Capa</label>
                        <figure class="image capa_formulario">
                            <img src="https://bulma.io/images/placeholders/128x128.png">
                        </figure>
                    </div>
                    <div class="column is-4">
                        <label class="label">Screenshots</label>
                        <div class="columns">
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="https://bulma.io/images/placeholders/128x128.png">
                                </figure>
                            </div>
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="https://bulma.io/images/placeholders/128x128.png">
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset>
                    <legend>Acervo</legend>
                    <table class='table is-narrow is-fullwidth tabela_acervo'>
                        <thead>
                            <tr>
                                <th><i class="fas fa-gamepad"></i></th>
                                <th><i class="fas fa-list"></i></th>
                                <th><i class="fas fa-calendar"></i></th>
                                <th><i class="fas fa-calendar"></i></th>
                                <th><i class="fas fa-globe"></i></th>
                                <th><i class="fas fa-filter"></i></th>
                                <th><i class="fas fa-star"></i></th>
                                <th><i class="fas fa-money-bill-alt"></i></th>
                                <th><i class="fas fa-hdd"></i></th>
                                <th><i class="fas fa-compact-disc"></i> / <i class="fas fa-cloud"></i></th>
                                <th><i class="fas fa-shopping-cart"></i></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody>
                            @include('linha_acervo')
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan=11>&nbsp;</td>
                                <td>
                                    <a class="button is-link is-small btn_adicionar_linha">
                                        <strong><i class="fa fa-plus"></i></strong>
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </fieldset>
            </form>
        </section>
        <footer class="modal-card-foot">
            <div>
                <button class="button is-link">Salvar</button>
                <button class="button is-light btn_cancelar">Cancelar</button>
            </div>
            <button class="button is-pulled-right is-danger btn_excluir" style="display:none">Excluir</button>
        </footer>
    </div>
</div>