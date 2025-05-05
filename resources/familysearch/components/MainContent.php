<?php
/**
 * This file is part of the MediaWiki extension ChameleonThemes.
 *
 * ChameleonThemes is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * ChameleonThemes is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ChameleonThemes.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup extensions
 *
 * @license GPL-2.0-or-later
 * @author thomas-topway-it for KM-A
 */
 
// @credits https://github.com/ProfessionalWiki/chameleon/blob/master/src/MainContent.php


namespace Skins\Chameleon\Components;

use Skins\Chameleon\IdRegistry;

class MainContent extends Component {

	/**
	 * @return string
	 * @throws \MWException
	 */
	public function getHtml() {
		$idRegistry = IdRegistry::getRegistry();

		$topAnchor = $idRegistry->element( 'a', [ 'id' => 'top' ] );
		$mwIndicators = $idRegistry->element( 'div', [ 'id' => 'mw-indicators',
			'class' => 'mw-indicators', ], $this->buildMwIndicators() );

		$data = $this->getSkinTemplate()->data;

		if ( array_key_exists( 'sitenotice', $data ) && $data[ 'sitenotice' ] ) {

			$siteNotice = '<!-- sitenotice -->' . $this->indent() .
				'<div id="siteNotice" class="siteNotice" >' .
				$data[ 'sitenotice' ] . '</div>' . "\n";
		} else {
			$siteNotice = '';
		}

		$mwBody =
			$topAnchor .
			$this->indent( 1 ) . $siteNotice .
			$this->indent( 1 ) . $mwIndicators .

			$this->buildContentHeader() .
			$this->buildContentBody() .
			$this->buildCategoryLinks() .
			$this->indent( -1 );

		return $this->indent() . '<!-- start the content area -->' .
			$this->indent() . $idRegistry->element(
				'div',
				[ 'id' => 'content', 'class' => 'mw-body ' . $this->getClassString() ],
				$mwBody
			);
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildContentHeader() {
		$skintemplate = $this->getSkinTemplate();
		$idRegistry = IdRegistry::getRegistry();

		$firstHeading =
			$this->indent( 1 ) . '<!-- title of the page -->' .
			$this->indent() . $idRegistry->element( 'h1', [ 'id' => 'firstHeading' ],
				$skintemplate->get( 'title' ) );

		// @codingStandardsIgnoreStart
		$siteSub =
			$this->indent() . '<!-- tagline; usually goes something like "From WikiName" primary purpose of this seems to be for printing to identify the source of the content -->' .
			$this->indent() . $idRegistry->element( 'div', [ 'id' => 'siteSub' ], $skintemplate->getMsg( 'tagline' )->escaped() );
		// @codingStandardsIgnoreEnd

		$contentSub = '';
		if ( $skintemplate->get( 'subtitle' ) ) {

			// TODO: should not use class 'small', better use class 'contentSub' and do styling in a
			// scss file
			$contentSub =
				$this->indent() .
				'<!-- subtitle line; used for various things like the subpage hierarchy -->' .
				$this->indent() . $idRegistry->element( 'div', [ 'id' => 'contentSub', 'class' => 'small' ],
				$skintemplate->get( 'subtitle' ) );

		}

		$contentSub2 = '';
		if ( $skintemplate->get( 'undelete' ) ) {
			// TODO: should not use class 'small', better use class 'contentSub2' and do styling in a
			// scss file
			$contentSub2 =
				$this->indent() . '<!-- undelete message -->' .
				$this->indent() . $idRegistry->element( 'div',
				[ 'id' => 'contentSub2', 'class' => 'small' ], $skintemplate->get( 'undelete' ) );
		}

		// $jumpToNav = $idRegistry->element(
		// 	'div',
		// 	[ 'id' => 'jump-to-nav', 'class' => 'mw-jump' ],
		// 	$skintemplate->getMsg( 'jumpto' )->escaped() . $idRegistry->element( 'a',
		// 	[ 'href' => '#mw-navigation' ], $skintemplate->getMsg( 'jumptonavigation' )->escaped() ) .
		// 	$skintemplate->getMsg( 'comma-separator' )->escaped() . $idRegistry->element( 'a',
		// 	[ 'href' => '#p-search' ], $skintemplate->getMsg( 'jumptosearch' )->escaped() )
		// );

		return $this->indent()
			. $idRegistry->element(
				'div',
				[ 'class' => "contentHeader" ],
				$firstHeading .
				$siteSub .
				$contentSub .
				$contentSub2 .
			//	$jumpToNav .
				$this->indent( -1 )
			);
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildContentBody() {
		return $this->indent() . IdRegistry::getRegistry()->element(
				'div',
				[ 'id' => 'bodyContent' ],

				$this->indent( 1 ) . '<!-- body text -->' . "\n" .
				$this->indent() . $this->getSkinTemplate()->get( 'bodytext' ) .
				$this->indent() . '<!-- end body text -->' .
				$this->buildDataAfterContent() .
				$this->indent( -1 )
			);
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildCategoryLinks() {
		// TODO: Category links should be a separate component, but
		// * dataAfterContent should come after the the category links.
		// * only one extension is known to use it dataAfterContent and it is geared specifically
		// towards MonoBook
		if ( $this->getDomElement() !== null &&
			filter_var( $this->getDomElement()->getAttribute( 'hideCatLinks' ), FILTER_VALIDATE_BOOLEAN )
		) {
			return '';
		} else {
			return $this->indent() . '<!-- category links -->' .
				$this->indent() . $this->getSkinTemplate()->get( 'catlinks' );
		}
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDataAfterContent() {
		$dataAfterContent = $this->getSkinTemplate()->get( 'dataAfterContent' );

		if ( $dataAfterContent !== null ) {
			// @codingStandardsIgnoreStart
			return $this->indent() . '<!-- data blocks which should go somewhere after the body text, but not before the catlinks block-->' .
				$this->indent() . $dataAfterContent;
			// @codingStandardsIgnoreEnd
		}

		return '';
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	private function buildMwIndicators() {
		$idRegistry = IdRegistry::getRegistry();
		$indicators = $this->getSkinTemplate()->get( 'indicators' );

		if ( !is_array( $indicators ) || count( $indicators ) === 0 ) {
			return '';
		}

		$this->indent( 1 );

		$ret = '';
		foreach ( $indicators as $id => $content ) {
			$ret .=
				$this->indent() .
				$idRegistry->element(
					'div',
					[
						'id' => \Sanitizer::escapeIdForAttribute( "mw-indicator-$id" ),
						'class' => 'mw-indicator'
					],
					$content
				);
		}

		$ret .= $this->indent( -1 );

		return $ret;
	}

}
