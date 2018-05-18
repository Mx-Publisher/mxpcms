
<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
    <tr>
      <th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
    </tr>
    <tr>
      <td class="row1"><p>{L_STARTKIT_CONFIG1}<br>
          <span class="gensmall">{L_STARTKIT_CONFIG1_EXPLAIN}</span> </p></td>
      <td class="row2"><input type="text" maxlength="5" size="5" name="startkit_config1" value="{STARTKIT_CONFIG1}" /></td>
    </tr>
    <tr>
      <td class="row1">{L_STARTKIT_CONFIG2}<br>
        <span class="gensmall">{L_STARTKIT_CONFIG2_EXPLAIN}</span> </td>
      <td class="row2"><input type="radio" name="startkit_config2" value="1" {S_STARTKIT_CONFIG2_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="startkit_config2" value="0" {S_STARTKIT_CONFIG2_NO} />
        {L_NO}</td>
    </tr>
    <tr>
      <td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /> 
        &nbsp;&nbsp; <input type="reset" value="{L_RESET}" class="liteoption" /> 
      </td>
    </tr>
  </table>
</form>

<br clear="all" />
