class Helper {

    spasiToEnterTd(text){
        text.trim();
        return  text.replace(/\s{2,}/g, '<br>');
    }
}

export default new Helper();