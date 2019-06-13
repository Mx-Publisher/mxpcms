<!--
Example of initializing:
  var menu = new XulMenu("id_of_the_menu");
  menu.init();

Example of initializing and setting additional stuff:
  var menu1 = new XulMenu("menu1");
  menu1.type = "horizontal";
  menu1.position.level1.top = 0;
  menu1.position.level1.left = 0;
  menu1.position.levelX.top = 0;
  menu1.position.levelX.left = 0;
  menu1.arrow1 = "images/arrow.gif";
  menu1.arrow2 = "images/arrow-active.gif";

Note:
  arrow1 & arrow2 set only when you want the arrow image to change when
  element is active. If you don't want the arrow to change keep both variables empty.

----------------
API
----------------

Controlling the menu:

  show(id)
  hide(id)
  hideAll()
  hideHigherOrEqualLevels(n)

  id = id of the element
  n = level

  examples:

  1)
  menu1.show("menu1-1");

  2)
  menu1.show("menu1-1");
  menu1.show("menu1-1-2");
  menu1.show("menu1-1-2-0");
  menu1.hideHigherOrEqualLevels(2);

  Both examples show the same.
-->

<script type="text/javascript">
 var menu1 = new XulMenu('menu' + '{$block_id}');
 menu1.type = "vertical";
 menu1.position.level1.top = 0;
 menu1.position.level1.left = 0;
 menu1.position.levelX.top = 0;
 menu1.position.levelX.left = 0;
 menu1.arrow1 = "images/arrow1.gif";
 menu1.arrow2 = "images/arrow2.gif";
 menu1.init();
</script>