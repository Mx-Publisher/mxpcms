/* SimpleDoc [www.gosu.pl], style for DynamicTree */
.DynamicTree {
    font-family: georgia, tahoma;
    font-size: 11px;
    white-space: nowrap;
    cursor: default;
}
.DynamicTree .wrap1,
.DynamicTree .actions { -moz-user-select: none; }

.DynamicTree a,
.DynamicTree a:hover { color: #000000; text-decoration: none; cursor: default; }

.DynamicTree .text { padding: 1px; cursor: pointer; }
.DynamicTree .text-active { color: #999999; padding: 1px; cursor: pointer; }


.DynamicTree div.folder img,
.DynamicTree div.doc img { border: 0; vertical-align: -30%; }
* html .DynamicTree .folder img,
* html .DynamicTree .doc img { vertical-align: -40%; }
.DynamicTree .section { background: url(images/tree-branch.gif) repeat-y; display: none; }
.DynamicTree .last { background: none; }
.DynamicTree div.folder div.folder { margin-left: 18px; }
.DynamicTree div.doc div.doc, .DynamicTree div.folder div.doc { margin-left: 18px; }

.DynamicTree ul {}
.DynamicTree li.folder {}
.DynamicTree li.doc {}

.DynamicTree .actions {
    position: relative;
    margin-top: 7px;
    margin-left: 0px;
    height: 20px;
}
.DynamicTree .tooltip {
    position: absolute;
    line-height: 22px;
    left: 0px;
}
.DynamicTree .moveUp,
.DynamicTree .moveDown,
.DynamicTree .moveLeft,
.DynamicTree .moveRight,
.DynamicTree .insert,
.DynamicTree .remove {
    width: 20px;
    height: 20px;
    display: block;
    position: absolute;
    border: 1px solid #F1EFE2;
    z-index: 5;
    cursor: default;
}
.DynamicTree .moveUp:hover,
.DynamicTree .moveDown:hover,
.DynamicTree .moveLeft:hover,
.DynamicTree .moveRight:hover,
.DynamicTree .insert:hover,
.DynamicTree .remove:hover {
    background-color: #ffffff;
    border: 1px solid #ACA899;
}
.DynamicTree .moveUp { left: 0px; }
.DynamicTree .moveDown { left: 25px; }
.DynamicTree .moveLeft { left: 50px; }
.DynamicTree .moveRight { left: 75px; }
.DynamicTree .insert { left: 100px; }
.DynamicTree .remove { left: 125px; }

.DynamicTree .top { padding-left: 0px; line-height: 20px; color: #333333; border-width: 1px; border-color: #aca899; border-style: none none border-width: 1px; border-color: #aca899; border-style: none none solid none; margin-bottom: 5px;}
.DynamicTree .wrap1 { padding: 10px; border: 1px solid #919B9C; width: 148px; }
.DynamicTree .wrap2 { margin-left: 2px; }

.DynamicTree #tree-insert-form { display: none; margin-top: 1em; }
.DynamicTree #tree-insert-form .label { text-align: right; width: 50px; padding-right: 8px; }
.DynamicTree #tree-insert-form .input { margin-bottom: 2px; padding-left: 3px; }
.DynamicTree #tree-insert-form select { margin-bottom: 2px; }
.DynamicTree #tree-insert-form .button { margin-top: 4px; }