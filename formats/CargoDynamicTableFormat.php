<?php
/**
 * Defines a "dynamic table" format, that displays query results in a
 * JavaScript-based table that has sorting, pagination and searching, using
 * the DataTables JS library.
 *
 * @author Yaron Koren
 * @ingroup Cargo
 */

class CargoDynamicTableFormat extends CargoDisplayFormat {

	function allowedParameters() {
		return array();
	}

	/**
	 *
	 * @param array $valuesTable Unused
	 * @param array $formattedValuesTable
	 * @param array $fieldDescriptions
	 * @param array $displayParams Unused
	 * @return string HTML
	 */
	function display( $valuesTable, $formattedValuesTable, $fieldDescriptions, $displayParams ) {
		$this->mOutput->addModules( 'ext.cargo.datatables' );

		$text = <<<END
	<table class="cargoDynamicTable display" cellspacing="0" width="100%">
		<thead>
			<tr>

END;
		foreach ( $fieldDescriptions as $fieldName => $fieldDescription ) {
			if ( strpos( $fieldName, 'Blank value ' ) === false ) {
				$text .= "\t\t\t\t" . Html::element( 'th', null, $fieldName );
			}
			else {
				$text .= "\t\t\t\t" . Html::element( 'th', null, null );
			}
		}

		$text .=<<<END
			</tr>
		</thead>

		<tfoot>
			<tr>

END;

		foreach ( $fieldDescriptions as $fieldName => $fieldDescription ) {
			if ( strpos( $fieldName, 'Blank value ' ) === false ) {
				$text .= "\t\t\t\t" . Html::element( 'th', null, $fieldName );
			}
			else {
				$text .= "\t\t\t\t" . Html::element( 'th', null, null );
			}
		}

		$text .=<<<END
			</tr>
		</tfoot>

		<tbody>

END;

		foreach ( $formattedValuesTable as $row ) {
			$text .= "\t\t\t<tr>\n";
			foreach ( array_keys( $fieldDescriptions ) as $field ) {
				if ( array_key_exists( $field, $row ) ) {
					$value = $row[$field];
				} else {
					$value = null;
				}
				$text .= "\t\t\t\t" . Html::rawElement( 'td', null, $value ); 
			}
			$text .= "\t\t\t</tr>\n";
		}

		$text .=<<<END
		</tbody>
	</table>

END;

		return $text;
	}

}
