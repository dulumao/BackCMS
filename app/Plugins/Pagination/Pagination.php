<?php

namespace App\Plugins\Pagination;

use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;

class Pagination implements PresenterContract
{

    use UrlWindowPresenterTrait;

    protected $paginationWrapper    = '<ul class="uk-pagination">%s %s %s</ul>';
    protected $disabledPageWrapper  = '<li class="uk-disabled"><span>%s</span></li>';
    protected $activePageWrapper    = '<li class="uk-active"><span>%s</span></li>';
    protected $previousButtonText   = '<i class="uk-icon-angle-double-left"></i>';
    protected $nextButtonText       = '<i class="uk-icon-angle-double-right"></i>';
    protected $availablePageWrapper = '<li><a href="%s">%s</a></li>';
    protected $dotsText             = '...';

    protected $paginator;
    protected $window;

    public function run()
    {
        return $this;
    }

    public function create( PaginatorContract $paginator, UrlWindow $window = null )
    {
        $this->paginator = $paginator;
        $this->window    = is_null( $window ) ? UrlWindow::make( $paginator ) : $window->get();

        return $this;
    }


    public function simpleCreate( PaginatorContract $paginator )
    {
        $this->paginator = $paginator;

        return $this;
    }

    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    public function render()
    {
        if ( $this->hasPages() ) {
            return sprintf(
                $this->getPaginationWrapperHTML(),
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }

    protected function getAvailablePageWrapper( $url, $page )
    {
        return sprintf( $this->getAvailablePageWrapperHTML(), $url, $page );
    }

    protected function getDisabledTextWrapper( $text )
    {
        return sprintf( $this->getDisabledPageWrapperHTML(), $text );
    }

    protected function getActivePageWrapper( $text )
    {
        return sprintf( $this->getActivePageWrapperHTML(), $text );
    }

    protected function getDots()
    {
        return $this->getDisabledTextWrapper( $this->getDotsText() );
    }

    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }

    protected function getPageLinkWrapper( $url, $page )
    {
        if ( $page == $this->paginator->currentPage() ) {
            return $this->getActivePageWrapper( $page );
        }

        return $this->getAvailablePageWrapper( $url, $page );
    }

    protected function getPreviousButton()
    {
        if ( $this->paginator->currentPage() <= 1 ) {
            return $this->getDisabledTextWrapper( $this->getPreviousButtonText() );
        }
        $url = $this->paginator->url(
            $this->paginator->currentPage() - 1
        );

        return $this->getPageLinkWrapper( $url, $this->getPreviousButtonText() );
    }


    protected function getNextButton()
    {
        if ( !$this->paginator->hasMorePages() ) {
            return $this->getDisabledTextWrapper( $this->getNextButtonText() );
        }
        $url = $this->paginator->url( $this->paginator->currentPage() + 1 );

        return $this->getPageLinkWrapper( $url, $this->getNextButtonText() );
    }

    protected function getAvailablePageWrapperHTML()
    {
        return $this->availablePageWrapper;
    }

    protected function getActivePageWrapperHTML()
    {
        return $this->activePageWrapper;
    }

    protected function getDisabledPageWrapperHTML()
    {
        return $this->disabledPageWrapper;
    }

    protected function getPreviousButtonText()
    {
        return $this->previousButtonText;
    }

    protected function getNextButtonText()
    {
        return $this->nextButtonText;
    }

    protected function getDotsText()
    {
        return $this->dotsText;
    }

    protected function getPaginationWrapperHTML()
    {
        return $this->paginationWrapper;
    }

}