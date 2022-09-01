<?php get_header(); ?>

<main>
    <section class="container d-flex flex-column align-items-center justify-content-center bg-schedule" id="search-field">
        <?php includeFile('components/search-input.php', array(
            'search_page' => 'agendadeatividades'
        ))?>

        <div class="w-100 d-flex justify-content-start" id="filters">
            <div class="row w-75">
                <!-- <div class="col-12 col-lg-4">
                    <select class="w-100" name="" id="">
                        <option value="">MÊS</option>
                        <option value="">JANEIRO</option>
                        <option value="">FEVEREIRO</option>
                        <option value="">MARÇO</option>
                        <option value="">ABRIL</option>
                        <option value="">MAIO</option>
                        <option value="">JUNHO</option>
                        <option value="">JULHO</option>
                        <option value="">AGOSTO</option>
                        <option value="">SETEMBRO</option>
                        <option value="">OUTUBRO</option>
                        <option value="">NOVEMBRO</option>
                        <option value="">DEZEMBRO</option>
                    </select>
                </div>

                <div class="col-12 col-lg-4">
                    <select class="w-100" name="" id="">
                        <option value="">ANO</option>
                        <option value="">2022</option>
                        <option value="">2021</option>
                        <option value="">2020</option>
                        <option value="">2019</option>
                    </select>
                </div> -->
                <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
                    <?php
                        echo '<select name="yearfilter"><option value="">Qualquer ano</option>';
                        for($i = date("Y"); $i >= date("Y")-3; $i--)
                            echo '<option value="'.$i.'"> '.$i.' </option>';
                        echo '</select>';
                    ?>
                    <select class="w-100" name="monthfilter" id="">
                        <option value="">MÊS</option>
                        <option value="1">JANEIRO</option>
                        <option value="2">FEVEREIRO</option>
                        <option value="3">MARÇO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAIO</option>
                        <option value="6">JUNHO</option>
                        <option value="7">JULHO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SETEMBRO</option>
                        <option value="10">OUTUBRO</option>
                        <option value="11">NOVEMBRO</option>
                        <option value="12">DEZEMBRO</option>
                    </select>
                    <button>Buscar</button>
	                <input type="hidden" name="action" value="agendadeatividadesfilter">
                </form>
            </div>
        </div>
    </section>

    <section class="container mb-3" id="list-agenda">
        <div class="row gx-3 gy-3" id="response">
            <?php 
                $args = array(
                    'post_type' => 'agendadeatividades'
                );
                $query = new WP_Query( $args );
                while ( $query -> have_posts()) : $query-> the_post();
            ?>
                <div class="col-12 col-lg-4">
                    <?php includeFile('components/card-schedule.php', array(
                        'image' => get_the_post_thumbnail_url(),
                        'title' => get_the_title(),
                        'date' => get_field('data_da_atividade'),
                        'time' => get_field('hora_da_atividade'),
                        'url' => get_the_permalink()
                    )) ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <nav class="pagination d-flex justify-content-center w-100 mb-4">
        <div class="pagination-wrapper d-flex justify-content-around">
            <?php 
                $url = get_home_url($post->ID) . '/resultados-da-busca/?results=' . $queryPrograma . '%5D%5B' . $queryDestino;
                $big = 999999999;
                $pagination_args = array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $busca_query->max_num_pages,
                    'prev_text' => '<',
                    'next_text' => '>'
                );
                echo paginate_links( $pagination_args );
            ?>
        </div>
    </nav>
</main>

<?php get_footer(); ?>