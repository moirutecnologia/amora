<section class="section pagina-inicio">
    <div class="container is-fullhd">
        <div class="columns is-centered is-mobile">
            <div class="column is-2-desktop is-6-mobile">
                <div class="field">
                    <div class="control">
                        <input id="data_de" class="input is-small" type="date" js-filtro-change <?php echo !$_usuario->assinante ? 'js-seja-assinante' : ''; ?> value="<?php echo !$_usuario->assinante ? date('Y-m-d', strtotime('-2 months')) : date('Y') . '-01-01'; ?>">
                    </div>
                </div>
            </div>
            <div class="column is-2-desktop is-6-mobile">
                <div class="field">
                    <div class="control">
                        <input id="data_ate" class="input is-small" type="date" js-filtro-change <?php echo !$_usuario->assinante ? 'js-seja-assinante' : ''; ?> value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div js-contadores>
        </div>
        <div class="columns is-multiline graficos">
            <div class="column is-6">
                <canvas id="grafico-vendas"></canvas>
            </div>
            <div class="column is-6">
                <canvas id="grafico-pagamentos"></canvas>
            </div>
            <div class="column is-6">
                <canvas id="grafico-investimentos"></canvas>
            </div>
            <div class="column is-6">
                <canvas id="grafico-ganhos"></canvas>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>