const types = {
	TOGGLE_DARK_MODE: "TOGGLE_DARK_MODE",
	TOGGLE_SYSTEM_PREFERENCE: "TOGGLE_SYSTEM_PREFERENCE",
    SWITCH_LANGUAGE: "SWITCH_LANGUAGE",
};

const initialState = {
	darkMode: Boolean(window.DEFAULT_DARKMODE),
    language: 'en',
	systemPreference: false
};

export default function reducer(state = initialState, action = {}) {
	switch (action.type) {
        case types.SWITCH_LANGUAGE:
            return {
                ...state,
                language: action.lang,
            };
		case types.TOGGLE_DARK_MODE:
			return {
				...state,
				darkMode: ! state.darkMode
			};
		case types.TOGGLE_SYSTEM_PREFERENCE:
			return {
				...state,
				systemPreference: ! state.systemPreference
			};
		default:
			return state;
	}
};
