<div class="modal modal_linha_acervo">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Adicionar</p>
        </header>
        <section class="modal-card-body">
            <form id='form_acervo'>
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
                        </tr>
                    </thead>
                    <tbody>
                        @include('linha_acervo', ['esconder_remover' => true])
                    </tbody>
                </table>
            </form>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-link btn_salvar_acervo">Salvar</button>
            <button class="button is-light btn_cancelar">Cancelar</button>
        </footer>
    </div>
</div>