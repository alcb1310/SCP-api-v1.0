import React, { useState, useEffect } from "react";
import Login from "./components/Login";
import axios from "axios";
import HomePage from "./pages/HomePage";

function Application() {
  const [user, setUser] = useState("");
  const [isInvalid, setIsInvalid] = useState(false);

  useEffect(() => {
    axios
      .get("/is-logged")
      .then((d) => setUser(d.data))
      .catch((e) => console.log(e.response));
  }, []);

  function logout(event) {
    event.preventDefault();
    axios.get("/logout").then((d) => setUser(""));
  }

  function login(event, username, password) {
    event.preventDefault();
    const data = { username, password };
    axios
      .post("/login", data)
      .then((d) => {
        setUser(username);
        setIsInvalid(false);
      })
      .catch((e) => {
        if (e.response.status === 401) setIsInvalid(true);
      });
  }

  const el = user ? (
    <HomePage username={user} logout={logout} />
  ) : (
    <Login login={login} isInvalid={isInvalid} />
  );

  return <div>{el}</div>;
}

export default Application;
