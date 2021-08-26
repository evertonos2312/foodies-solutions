<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<div class="col-12 text-center" aria-label="<?php echo lang('Pager.pageNavigation') ?>">
    <ul style="margin: 0;" class="paginacao">
        <?php if ($pager->hasPrevious()) : ?>
            <a class="client-pager" href="<?php echo $pager->getFirst() ?>" aria-label="<?php echo lang('Pager.first') ?>">
                <li>
                    <i class="fas fa-angle-double-left fa-lg align-self-center"></i>
                </li>
            </a>
            <a class="client-pager" href="<?php echo $pager->getPreviousPage() ?>" aria-label="<?php echo lang('Pager.previous') ?>">
                <li>
                    <i class="fas fa-chevron-left fa-lg align-self-center"></i>
                </li>
            </a>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <a class="client-pager" href="<?php echo $link['uri'] ?>">
                <li <?php echo $link['active'] ? 'class="ativo"' : '' ?>>
                    <?php echo $link['title'] ?>
                </li>
            </a>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <a class="client-pager" href="<?php echo $pager->getNextPage() ?>" aria-label="<?php echo lang('Pager.next') ?>">
                <li>
                    <i class="fas fa-chevron-right"></i>
                </li>
            </a>
            <a class="client-pager" href="<?php echo $pager->getLast() ?>" aria-label="<?php echo lang('Pager.last') ?>">
                <li>
                    <i class="fas fa-angle-double-right"></i>
                </li>
            </a>
        <?php endif ?>
    </ul>
</div>