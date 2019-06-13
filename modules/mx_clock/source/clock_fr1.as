// Action script...

// [Action in Frame 1]
function howlong(arg)
{
    if (length(arg) == 1)
    {
        arg = "0" + arg;
        return (arg);
    }
    else
    {
        arg = arg;
        return (arg);
    } // end else if
} // End of the function
myDate = new Date();
daytext = myDate.getDay();
dd = myDate.getDate();
switch (daytext)
{
    case 0:
    {
        daytext = "Dum";
        break;
    } 
    case 1:
    {
        daytext = "Lun";
        break;
    } 
    case 2:
    {
        daytext = "Mar";
        break;
    } 
    case 3:
    {
        daytext = "Mie";
        break;
    } 
    case 4:
    {
        daytext = "Joi";
        break;
    } 
    case 5:
    {
        daytext = "Vin";
        break;
    } 
    case 6:
    {
        daytext = "Sam";
        break;
    } 
} // End of switch
textdate = dd + " ";

time = new Date();
seconds = time.getSeconds();
minutes = time.getMinutes() + _root.gMToAdd;
hours = time.getHours() + _root.gHToAdd;
hours = hours + minutes / 60;
seconds = seconds * 6;
if (time.getMilliseconds() < 999)
{
    seconds = seconds + time.getMilliseconds() / 999 * 6;
} // end if
minutes = minutes * 6;
hours = hours * 30;
sec._rotation = seconds;
min._rotation = minutes;
hour._rotation = hours;

function howlong(arg)
{
    if (length(arg) == 1)
    {
        arg = "0" + arg;
        return (arg);
    }
    else
    {
        arg = arg;
        return (arg);
    } // end else if
} // End of the function
myDate = new Date();
daytext = myDate.getDay();
dd = myDate.getDate();
switch (daytext)
{
    case 0:
    {
        daytext = "Dum";
        break;
    } 
    case 1:
    {
        daytext = "Lun";
        break;
    } 
    case 2:
    {
        daytext = "Mar";
        break;
    } 
    case 3:
    {
        daytext = "Mie";
        break;
    } 
    case 4:
    {
        daytext = "Joi";
        break;
    } 
    case 5:
    {
        daytext = "Vin";
        break;
    } 
    case 6:
    {
        daytext = "Sam";
        break;
    } 
} // End of switch
textdate = dd + " ";

time = new Date();
seconds = time.getSeconds();
minutes = time.getMinutes() + _root.gMToAdd;
hours = time.getHours() + _root.gHToAdd;
hours = hours + minutes / 60;
seconds = seconds * 6;
if (time.getMilliseconds() < 999)
{
    seconds = seconds + time.getMilliseconds() / 999 * 6;
} // end if
minutes = minutes * 6;
hours = hours * 30;
sec._rotation = seconds;
min._rotation = minutes;
hour._rotation = hours;

// Action script...
on (release)
{
    if (_root.gnu.length > 0)
    {
        getURL(_root.gnu, "");
    } // end if
}
