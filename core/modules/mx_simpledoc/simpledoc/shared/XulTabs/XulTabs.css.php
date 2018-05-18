/* SimpleDoc [www.gosu.pl], style for tabs */
.XulTabs .wrap1 { height: 23px; }
.XulTabs .wrap1 td { vertical-align: bottom; }
.XulTabs .tab,
.XulTabs .tab:hover,
.XulTabs .tab-active,
.XulTabs .tab-active:hover {
    text-decoration: none;
    padding: 3px 10px 3px 10px;
    border-top: 1px solid #91A7B4;
    border-left: 1px solid #919B9C;
    color: #000000;
    cursor: default;
    white-space: nowrap;
    display: block;
}
.XulTabs .tab:hover {
    border-top: 2px solid #FFC73C;
    padding-top: 2px;
}
.XulTabs .tab-active,
.XulTabs .tab-active:hover {
    border-top: 3px solid #FFC73C;
    padding-top: 2px;
    padding-bottom: 4px;
    font-weight: bold;
}
.XulTabs .view {
    border-right: 1px solid #919B9C;
}
.XulTabs .content {
    border: 1px solid #919B9C;
    background: #ffffff;
    width: 100%;
    height: 100%;
}
.XulTabs .wrap2 {
    vertical-align: top;
    padding: 15px;
}
.XulTabs .data {
    display: none;
}

* html .XulTabs .tab,
* html .XulTabs .tab:hover,
* html .XulTabs .tab-active,
* html .XulTabs .tab-active:hover { width: 100%; }