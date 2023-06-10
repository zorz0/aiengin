import OneSignal from 'react-onesignal';
import {store} from "../store/configureStore";

export default async function runOneSignal() {
  await OneSignal.init({ appId: 'e3076dc2-3fb9-4b84-9bdf-737566e34e9b'});
  OneSignal.isPushNotificationsEnabled(function(isEnabled) {
    if (isEnabled)
      console.log("Push notifications are enabled!");
    else
      console.log("Push notifications are not enabled yet.");
  });
  OneSignal.showSlidedownPrompt();

  const auth = store.getState().auth;

  if(auth.isLogged) {

  }

}