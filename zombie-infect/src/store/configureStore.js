import { createStore, applyMiddleware, combineReducers, compose } from 'redux';
import thunkMiddleware from 'redux-thunk';
import createLogger from 'redux-logger';
import { incident } from '../infect/reducers';

const logger = createLogger();
const rootReducer = combineReducers(
  {
      incident,
  }
);

const initialState = {};


export default function configureStore() {
  let store;

  if (module.hot) {

      var composeEnhancers = compose; //window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
      store = createStore(rootReducer, initialState, composeEnhancers(
        applyMiddleware(thunkMiddleware, logger),
          window.devToolsExtension ? window.devToolsExtension() : f => f
    ));
  } else {
    store = createStore(rootReducer, initialState, compose(
      applyMiddleware(thunkMiddleware), f=>f
    ));
  }

  // DEBUG ** remove this
  //window.store = store;
  return store;
}
