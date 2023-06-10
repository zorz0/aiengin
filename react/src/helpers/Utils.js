import API from "./Axios";
import {store} from "../store/configureStore";

export const textGenerator = (data) => {
    return new Promise((resolve, reject) => {
        API.post('auth/user/text-generator', data).then((res) => {
            if(res.data && res.data.usage) {
                store.dispatch({type: 'UPDATE_TOKENS', tokens: store.getState().common.tokens - res.data.usage});
            }
            resolve(res);
        }).catch (error => {
            alert('The server had an error while processing your request. Sorry about that!');
            console.log(error.response);
            reject(error);
        });
    });
};

export const sleep = (time) =>
  new Promise((res) => setTimeout(res, time));

export const calculateWindowSize = (windowWidth) => {
  if (windowWidth >= 1200) {
    return 'lg';
  }
  if (windowWidth >= 992) {
    return 'md';
  }
  if (windowWidth >= 768) {
    return 'sm';
  }
  return 'xs';
};

export const setWindowClass = (classList) => {
  const window = document.body;
  if (window) {
    // @ts-ignore
    window.classList = classList;
  }
};
export const addWindowClass = (classList) => {
  const window = document.body;
  if (window) {
    // @ts-ignore
    window.classList.add(classList);
  }
};

export const removeWindowClass = (classList) => {
  const window = document.body;
  if (window) {
    // @ts-ignore
    window.classList.remove(classList);
  }
};

export const hexToRgbA = (hex) => {
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+', .1)';
    }
    throw new Error('Bad Hex');
}

export const copyText = (string) => {
    navigator.clipboard.writeText(string);
}
