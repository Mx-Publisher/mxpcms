
				<!-- Standard Block Parameter -->
				<!-- BEGIN separator -->
				<tr>
					<td width="100%" colspan="2">
						<table cellpadding="2" cellspacing="0" width="100%">
							<tr title="{separator.PARAMETER_TYPE}{separator.PARAMETER_TYPE_INFO}">
								<td class="row2" width="100%" align="center" valign="top" colspan="2">
									<span class="cattitle">{separator.PARAMETER_TITLE}:</span>
									<span class="gensmall">{separator.PARAMETER_TITLE_EXPLAIN}</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- END separator -->

				<!-- BEGIN block_parameter -->
				<tr>
					<td width="100%" colspan="2">
						<table cellpadding="2" cellspacing="0" width="100%">
							<tr title="{block_parameter.PARAMETER_TYPE}{block_parameter.PARAMETER_TYPE_INFO}">
								<td class="row1" width="50%" align="right" valign="top">
									<span class="topictitle">{block_parameter.PARAMETER_TITLE}:</span>
									<span class="gensmall">{block_parameter.PARAMETER_TITLE_EXPLAIN}</span>
								</td>
								<td class="row1">{block_parameter.PARAMETER_FIELD}</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- END block_parameter -->

				<!-- Custom Block Parameters -->

				<!-- BEGIN radio -->
				<tr>
					<td width="100%" colspan="2">
						<table cellpadding="2" cellspacing="0" width="100%">
							<tr title="{radio.FIELD_DESCRIPTION}">
								<td class="row1" width="50%" align="right">
									<span class="topictitle">{radio.PARAMETER_TITLE}:</span>
									<span class="gensmall">{radio.PARAMETER_TITLE_EXPLAIN}</span>
								</td>
								<td class="row1">
								<!-- BEGIN row -->
									<input type="radio" name="{radio.FIELD_ID}" value="{radio.row.FIELD_VALUE}" {radio.row.FIELD_SELECTED} /><span class="gensmall">{radio.row.FIELD_VALUE}</span>&nbsp;
								<!-- END row -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- END radio -->

				<!-- BEGIN select -->
				<tr>
					<td width="100%" colspan="2">
						<table cellpadding="2" cellspacing="0" width="100%">
							<tr title="{select.FIELD_DESCRIPTION}">
								<td class="row1" width="50%" align="right">
									<span class="topictitle">{select.PARAMETER_TITLE}:</span>
									<span class="gensmall">{select.PARAMETER_TITLE_EXPLAIN}</span>
								</td>
								<td class="row1">
									<select name="{select.FIELD_ID}" class="post">
									<!-- BEGIN row -->
									<option value="{select.row.FIELD_VALUE}"{select.row.FIELD_SELECTED}>{select.row.FIELD_VALUE}</option>
									<!-- END row -->
									</select>
								</td>
				  			</tr>
						</table>
					</td>
				</tr>
				<!-- END select -->

				<!-- BEGIN select_multiple -->
				<tr>
					<td width="100%" colspan="2">
						<table cellpadding="2" cellspacing="0" width="100%">
							<tr title="{select_multiple.FIELD_DESCRIPTION}">
								<td class="row1" width="50%" align="right">
									<span class="topictitle">{select_multiple.PARAMETER_TITLE}:</span>
									<span class="gensmall">{select_multiple.PARAMETER_TITLE_EXPLAIN}</span>
								</td>
								<td class="row1">
									<select name="{select_multiple.FIELD_ID}[]" multiple="multiple" size="4" class="post">
									<!-- BEGIN row -->
									<option value="{select_multiple.row.FIELD_VALUE}"{select_multiple.row.FIELD_SELECTED}>{select_multiple.row.FIELD_VALUE}</option>
									<!-- END row -->
									</select>
								</td>
				  			</tr>
						</table>
					</td>
				</tr>
				<!-- END select_multiple -->

				<!-- BEGIN checkbox -->
				<tr>
					<td width="100%" colspan="2">
						<table cellpadding="2" cellspacing="0" width="100%">
							<tr title="{checkbox.FIELD_DESCRIPTION}">
								<td class="row1" width="50%" align="right">
									<span class="topictitle">{checkbox.PARAMETER_TITLE}:</span>
									<span class="gensmall">{checkbox.PARAMETER_TITLE_EXPLAIN}</span>
								</td>
								<td class="row1">
								<!-- BEGIN row -->
								<input type="checkbox" name="{checkbox.FIELD_ID}[{checkbox.row.FIELD_VALUE}]" value="{checkbox.row.FIELD_VALUE}" {checkbox.row.FIELD_CHECKED}><span class="gensmall">{checkbox.row.FIELD_VALUE}</span>&nbsp;
								<!-- END row -->
								</td>
				 		 	</tr>
						</table>
					</td>
				</tr>
				<!-- END checkbox -->
