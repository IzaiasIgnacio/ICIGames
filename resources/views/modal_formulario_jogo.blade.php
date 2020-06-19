<div class="modal modal_jogo" id='modal_formulario_jogo'>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Adicionar jogo</p>
            <button class="delete fechar_modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form id='form_jogo'>
                <input type='hidden' name='id_jogo' id='id_jogo'>
                <input type='hidden' name='id_igdb' id='id_igdb'>
                <div class="columns">
                    <div class="column is-3">
                    <label class="label">Título</label>
                        <div class="field">
                            <div class="control has-icons-right">
                                <input class="input" type="text" id="campo_busca" placeholder="Título" name='titulo'>
                                <span class="icon is-small is-right" style='display:none'>
                                    <i class="fas fa-spin fa-circle-notch"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Descrição</label>
                            <div class="control">
                                <textarea class="textarea" name='descricao' id='descricao' placeholder="Descrição" style='height: 250px'></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Nota</label>
                            <div class="control input_nota">
                                <input class="input" type="number" name='nota' id='nota' placeholder="Nota" step="0.1">
                            </div>
                        </div>
                        <label class="checkbox label">
                        <input type="checkbox" name='completo' id='completo'> Completo</label>
                    </div>
                    <div class="column is-2 coluna_igdb" style="display:none">
                        <div class="field">
                            <label class="label">Desenvolvedores</label>
                            <div class="control">
                                <label class='dados_igdb' name='desenvolvedores' id='desenvolvedores'></label>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Distribuidores</label>
                            <div class="control">
                                <label class='dados_igdb' name='distribuidores' id='distribuidores'></label>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Gênero</label>
                            <div class="control">
                                <label class='dados_igdb' name='generos' id='generos'></label>
                            </div>
                        </div>
                    </div>
                    <div class="column is-3 coluna_igdb" style="display:none">
                    <label class="label">Capa</label>
                        <figure class="image capa_formulario">
                            <img src="" name='capa' id='capa'>
                        </figure>
                    </div>
                    <div class="column is-4 coluna_igdb" style="display:none">
                        <label class="label">Screenshots</label>
                        <div class="columns is-gapless is-multiline">
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="" id='screen_1'>
                                </figure>
                            </div>
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="" id='screen_2'>
                                </figure>
                            </div>
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="" id='screen_3'>
                                </figure>
                            </div>
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="" id='screen_4'>
                                </figure>
                            </div>
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="" id='screen_5'>
                                </figure>
                            </div>
                            <div class="column is-6">
                                <figure class="image screenshots_formulario">
                                    <img src="" id='screen_6'>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class='coluna_igdb'>
                    <legend>Acervo</legend>
                    <table class='table is-narrow is-fullwidth tabela_acervo'>
                        <thead>
                            <tr>
                                <th width='11%'><i class="fas fa-gamepad"></i></th>
                                <th width='11%'><i class="fas fa-clipboard-check"></i></th>
                                <th width='11%'>
                                    <span class="fa-stack">
                                        <i class="fas fa-calendar fa-stack-2x"></i>
                                        <i class="fa fa-shipping-fast fa-stack-1x"></i>
                                    </span>
                                </th>
                                <th width='11%'>
                                    <span class="fa-stack">
                                        <i class="fas fa-calendar fa-stack-2x"></i>
                                        <i class="fa fa-shopping-cart fa-stack-1x"></i>
                                    </span>
                                </th>
                                <th width='9%'><i class="fas fa-globe"></i></th>
                                <th width='9%'><i class="fas fa-filter"></i></th>
                                <th width='5%'><i class="fas fa-star"></i></th>
                                <th width='5%'><i class="fas fa-money-bill-alt"></i></th>
                                <th width='5%'><i class="fas fa-hdd"></i></th>
                                <th width='6%'><i class="fas fa-compact-disc"></i> / <i class="fas fa-cloud"></i></th>
                                <th width='11%'><i class="fas fa-shopping-cart"></i></th>
                                <th width='1%'>&nbsp;</th>
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
                <button class="button is-link btn_salvar">Salvar</button>
                <button class="button is-light btn_cancelar">Cancelar</button>
                <label class='label_progresso'></label>
            </div>
            <button class="button is-pulled-right is-danger btn_excluir" style="display:none">Excluir</button>
        </footer>
    </div>
</div>