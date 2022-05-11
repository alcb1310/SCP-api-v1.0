import React, { useState } from "react";
import {
  Button,
  Col,
  Form,
  FormGroup,
  Input,
  Label,
  Row,
  FormFeedback,
  FormText,
} from "reactstrap";

function Login(props) {
  const [username, setUserName] = useState("");
  const [password, setPassword] = useState("");

  function changeUser(event) {
    const { value } = event.target;
    setUserName(value);
  }

  function changePassword(event) {
    const { value } = event.target;
    setPassword(value);
  }

  function handleClick(event) {
    props.login(event, username, password);
    setUserName("");
    setPassword("");
  }

  return (
    <Form className="mt-3" onSubmit={handleClick}>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <FormGroup>
            <Label for="username">Username</Label>
            <Input
              id="username"
              placeholder="username"
              value={username}
              onChange={changeUser}
              invalid={props.isInvalid}
            />
            <FormFeedback>
              Nombre de usuario o contraseña inválidos
            </FormFeedback>
          </FormGroup>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <FormGroup>
            <Label for="password">Password</Label>
            <Input
              type="password"
              placeholder="password"
              value={password}
              onChange={changePassword}
            />
          </FormGroup>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <FormGroup>
            <Button color="primary" outline>
              Submit
            </Button>
          </FormGroup>
        </Col>
      </Row>
    </Form>
  );
}

export default Login;
