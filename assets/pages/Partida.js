import axios from "axios";
import React, { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";
import { faCheck, faXmark } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Row, Col, Table, Button, Input } from "reactstrap";
import PartidaForm from "../components/PartidaForm";

function Partida() {
  const [partidas, setPartidas] = useState([]);
  const [maxPages, setMaxPages] = useState(0);
  const [showForm, setShowForm] = useState(false);
  const [isEdit, setIsEdit] = useState(false);
  const [loadPartidas, setLoadPartidas] = useState(false);
  const [selectedPartida, setSelectedPartida] = useState({});
  const [search, setSearch] = useState("");
  const [params, setParams] = useState({});
  const url = "/api/partidas";

  useEffect(() => {
    axios.get(url, { params }).then((d) => {
      setPartidas(d.data["hydra:member"]);
      if (d.data["hydra:view"]["hydra:last"]) {
        let p = d.data["hydra:view"]["hydra:last"].search("page=");
        let number = d.data["hydra:view"]["hydra:last"].slice(p + 5);
        p = number.indexOf("?");
        if (p === -1) {
          setMaxPages(parseInt(number));
        } else {
          number = number.slice(0, p);
          setMaxPages(parseInt(number));
        }
      }
    });
  }, [params, loadPartidas]);

  function toggleLoadPartida() {
    setLoadPartidas((prevLoad) => !prevLoad);
  }

  const handlePageClick = (event) => {
    const page = event.selected + 1;
    setParams((prevParams) => ({ ...prevParams, page }));
  };

  function editPartida(id) {
    const data = partidas.find((part) => {
      return part["@id"] === id;
    });
    setSelectedPartida(data);
    setIsEdit(true);
    setShowForm(true);
  }

  function addPartida() {
    setIsEdit(false);
    setShowForm(true);
  }

  function closeForm() {
    setSelectedPartida({});
    setShowForm(false);
  }

  function partidaSearch(event) {
    setSearch(event.target.value);
    setParams((prevParams) => ({ ...prevParams, search: event.target.value }));
  }

  const tableData = partidas.map((partida) => (
    <tr key={partida["@id"]} onClick={() => editPartida(partida["@id"])}>
      <td>{partida.codigo}</td>
      <td>{partida.nombre}</td>
      <td>{partida.nivel}</td>
      <td>
        <FontAwesomeIcon icon={partida.acumula ? faCheck : faXmark} />
      </td>
      <td>{partida.padre ? partida.padre.codigo : ""}</td>
    </tr>
  ));

  const partidaForm = showForm && (
    <PartidaForm
      isEdit={isEdit}
      toggleLoadPartida={toggleLoadPartida}
      closeForm={closeForm}
      selectedPartida={selectedPartida}
    />
  );

  return (
    <>
      <Row className="mb-5">
        <Col md={{ offset: 2, size: 8 }}>{partidaForm}</Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <h3>Partidas</h3>
        </Col>
        <Col md={2}>
          <Button color="primary" outline onClick={addPartida}>
            Agregar
          </Button>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <ReactPaginate
            pageCount={maxPages}
            breakLabel="..."
            nextLabel=">>"
            onPageChange={handlePageClick}
            pageRangeDisplayed={5}
            previousLabel="<<"
            renderOnZeroPageCount={null}
            containerClassName="pagination pagination-sm"
            pageClassName="page-item"
            pageLinkClassName="page-link"
            previousClassName="page-item"
            nextClassName="page-item"
            previousLinkClassName="page-link"
            nextLinkClassName="page-link"
            activeLinkClassName="active"
            activeClassName="active"
          />
        </Col>
        <Col md={{ size: 2 }}>
          <Input
            type="text"
            name="search"
            id="search"
            value={search}
            placeholder="Buscar"
            onChange={partidaSearch}
          />
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <Table hover size="sm">
            <thead>
              <tr>
                <td>Código</td>
                <td>Nombre</td>
                <td>Nivel</td>
                <td>Acumula</td>
                <td>Padre</td>
              </tr>
            </thead>
            <tbody>{tableData}</tbody>
          </Table>
        </Col>
      </Row>
    </>
  );
}

export default Partida;
