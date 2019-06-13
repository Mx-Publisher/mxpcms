	<div id="outer_1_col">
	<div id="inner">

	<!-- BEGIN layout_column -->
	<div id="{layout_column.COL_CLASS}">

		<!-- BEGIN blocks -->
		<div class="blockcontainer">

			<!-- BEGIN block_header -->
			<div class="blockheader">
				<!-- END block_header -->

					<!-- BEGIN edit -->
						<div class="editCP_switch" style="display: {layout_column.blocks.edit.EDITCP_SHOW};">
							<form action="{layout_column.blocks.edit.EDIT_ACTION}" method="post" class="trimform">
								{layout_column.blocks.edit.EDIT_IMG}
								{layout_column.blocks.edit.S_HIDDEN_FORM_FIELDS}
							</form>
						</div>
						<!-- BEGIN hidden_block -->
						<div class="blockhidden">
							<span class="gensmall"><i>{layout_column.blocks.edit.hidden_block.HIDDEN_BLOCK}</i></span>
						</div>
						<!-- END hidden_block -->
					<!-- END edit -->

					<!-- BEGIN show_title -->
						<span class="blocktitle">{layout_column.blocks.show_title.L_TITLE}</span>
					<!-- END show_title -->

				<!-- BEGIN block_header -->
			</div>
			<!-- END block_header -->

			<div class="block" id="block_{layout_column.blocks.BLOCK_ID}">
				{layout_column.blocks.BLOCK}
			</div>

			<!-- BEGIN block_stats -->
			<!--
			<div align="right">
				<span class="copyright">{layout_column.blocks.block_stats.L_BLOCK_UPDATED} {layout_column.blocks.block_stats.EDIT_TIME} {layout_column.blocks.block_stats.EDITOR_NAME}</span>
			</div>
			-->
			<!-- END block_stats -->

		</div>
		<!-- END blocks -->

	</div>
	<!-- END layout_column -->

	<div id="clear"></div>

	</div>
	</div>
