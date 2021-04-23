<?php
/**
 * @var $totalPages - Кол-во страниц
 * @var $perPage - Кол-во записей на странице
 * @var $postType - Тип записи
 * @var $sort - Сортировка записей
 */
?>
<div class="nav-container"
     data-total-pages="<?= $totalPages ?>"
     data-perpage="<?= $perPage ?>"
     data-curpage="1"
     data-post-type="<?= $postType ?>"
     data-sort="<?= $sort ?>">
    <div class="nav_arrow hidden prev"></div>
    <div class="nav_arrow next"></div>
</div>
