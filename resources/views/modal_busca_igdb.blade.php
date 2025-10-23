<div class="modal" id='modal_busca_igdb'>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Resultados IGDB</p>
        </header>
        <section class="modal-card-body">
            <ul class="lista_jogos_igdb">
                {{-- Os resultados da busca serão inseridos aqui via JS --}}
            </ul>
        </section>
        <footer class="modal-card-foot">
            <div>
                <button class="button is-light btn_cancelar">Cancelar</button>
            </div>
        </footer>
    </div>
</div>
<style>
    .item_jogo_igdb { color: #fff; border-bottom: 1px solid #444; padding: 5px; cursor: pointer; }
    .item_jogo_igdb:hover { background-color: #4a4a4a; }
</style>