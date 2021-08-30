const site_key = '6Le2ZFUUAAAAAEV4IM_5weEnXg4gVplan2Atgiaj'

function isEmail(email)
{
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}