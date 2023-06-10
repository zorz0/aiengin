const types = {
    CHANGE_CONTENT_LANGUAGE: 'CHANGE_CONTENT_LANGUAGE',
    UPDATE_TOKENS: 'UPDATE_TOKENS',
    FAVORITE_CHANGE: 'FAVORITE_CHANGE',
    CURRENT_PROJECT_CHANGE: 'CURRENT_PROJECT_CHANGE',
    USER_PLAYLIST_CHANGE: 'USER_PLAYLIST_CHANGE',
    DOWNLOADS_CHANGE: 'DOWNLOADS_CHANGE',
    TOGGLE_OFFLINE: 'TOGGLE_OFFLINE',
    RECENT_CHANGE: 'RECENT_CHANGE'
};

const initialState = {
    contentLanguage: 'english',
    tokens: 0,
    currentProject: null,
    favoriteChange: 0,
    recentChange: 0,
    userPlaylistChange: 0,
    downloadsChange: 0,
    offlineMode: false
};

export default function reducer(state = initialState, action = {}) {
    switch (action.type) {
        case types.CHANGE_CONTENT_LANGUAGE:
            return {
                ...state,
                contentLanguage: action.language.toLowerCase(),
            };
        case types.UPDATE_TOKENS:
            return {
                ...state,
                tokens: action.tokens < 0 ? 0 : action.tokens,
            };
        case types.CURRENT_PROJECT_CHANGE:
            return {
                ...state,
                currentProject: action.project,
            };
        case types.FAVORITE_CHANGE:
            return {
                ...state,
                favoriteChange: state.favoriteChange + 1,
            };
        case types.RECENT_CHANGE:
            return {
                ...state,
                recentChange: state.recentChange + 1,
            };
        case types.USER_PLAYLIST_CHANGE:
            return {
                ...state,
                userPlaylistChange: state.userPlaylistChange + 1,
            };
        case types.DOWNLOADS_CHANGE:
            return {
                ...state,
                downloadsChange: state.downloadsChange + 1,
            };
        case types.TOGGLE_OFFLINE:
            return {
                ...state,
                offlineMode: !state.offlineMode,
            };
        default:
            return state;
    }
}
