// Action script...

// [onClipEvent of sprite 14 in frame 1]
onClipEvent (enterFrame)
{
    myDate = new Date();
    h = myDate.getHours() % 12;
    m = myDate.getMinutes();
    s = myDate.getSeconds();
    ha = 30 * h + 5.000000E-001 * m;
    ma = 6 * m;
    se = 6 * s;
    se_old = getProperty("_root.Clock.Second", _rotation);
    if (se_old < 0)
    {
        se_old = se_old + 360;
    } // end if
    if (se_old != se)
    {
        _root.Clock.Second.play();
    } // end if
    setProperty(_root.Clock.Hour, _rotation, ha);
    setProperty(_root.Clock.Minute, _rotation, ma);
    setProperty(_root.Clock.Second, _rotation, se);
    _root.Clock.Hrs = h;
    _root.Clock.Mins = m;
}
