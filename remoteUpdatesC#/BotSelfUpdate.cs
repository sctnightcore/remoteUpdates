using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class BotSelfUpdate : MonoBehaviour
{
    public Text bot_name_map_coords, bot_hp_text, bot_sp_text, bot_bxp_text, bot_cxp_text, bot_zeny, bot_weight;
    public Slider bot_hp_bar, bot_sp_bar, bot_bxp_bar, bot_cxp_bar;
    public string BotRealName;

    public string botStatus;
    public string[] bot_status;

    public float timer1;

    public GameObject inventario;
    public GameObject item_prefab;
    public GameObject usableItem_prefab;
    public Transform inventario_h, armazem_h;
    public Sprite usb_image, etc_image, eqp_image, card_image;

    public Button consoleButton;

    public GameObject status;
    public Text status1, status2;
    public bool statusAberto = false;

    public string host_address;

    private void Start()
    {
        consoleButton.name = transform.name;
        host_address = Camera.main.GetComponent<RemoteUpdates>().host_address;
        timer1 = 0.5f;
        inventario = Camera.main.GetComponent<RemoteUpdates>().inventario;
        inventario_h = Camera.main.GetComponent<RemoteUpdates>().inventario_h.transform;
        armazem_h = Camera.main.GetComponent<RemoteUpdates>().armazem_h.transform;
        status = Camera.main.GetComponent<RemoteUpdates>().status;
        status1 = Camera.main.GetComponent<RemoteUpdates>().status1;
        status2 = Camera.main.GetComponent<RemoteUpdates>().status2;
        ChangeToPortrait();
    }
    private void FixedUpdate()
    {
        timer1 -= Time.deltaTime;
        if ( timer1 <= 0 )
        {
            timer1 = 0.5f;
            StartCoroutine(UpdateBotInfo());
        }
        if ( Input.deviceOrientation == DeviceOrientation.Portrait )
        {
            ChangeToLandscape();
        }
        if ( Input.deviceOrientation == DeviceOrientation.LandscapeLeft || Input.deviceOrientation == DeviceOrientation.LandscapeRight )
        {
            ChangeToPortrait();
        }
    }

    void ChangeToPortrait()
    {
        GetComponent<LayoutElement>().preferredWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().minWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().flexibleWidth = Screen.currentResolution.width;
        GetComponent<RectTransform>().localScale = new Vector3(1f, 1f, 1f);
    }

    void ChangeToLandscape()
    {
        GetComponent<LayoutElement>().preferredWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().minWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().flexibleWidth = Screen.currentResolution.width;
        GetComponent<RectTransform>().localScale = new Vector3(1f, 1f, 1f);
    }

    public void AbrirInventario()
    {
        inventario.SetActive(true);
        Camera.main.GetComponent<RemoteUpdates>().currentScreen = "Inventario";
        Camera.main.GetComponent<RemoteUpdates>().currentUsingStatus = transform.name;
        StartCoroutine(GetInventario());
    }
    public void AbrirStatus()
    {
        status.SetActive(true);
        statusAberto = true;
        Camera.main.GetComponent<RemoteUpdates>().currentUsingStatus = transform.name;
        Camera.main.GetComponent<RemoteUpdates>().currentScreen = "Status";
    }
    IEnumerator UpdateBotInfo()
    {
        WWWForm form = new WWWForm();
        form.AddField("req_type", "extract");
        form.AddField("name", transform.name);

        UnityWebRequest www = UnityWebRequest.Post(host_address + "/remoteUpdatesPhp/main.php", form);
        yield return www.SendWebRequest();

        if (www.isNetworkError || www.isHttpError)
        {
            Debug.Log(www.error);
        }
        else
        {
            botStatus = www.downloadHandler.text;
            bot_status = botStatus.Split('/');
            UpdateBotTexts();
        }
    }

    void UpdateBotTexts()
    {
        if (bot_status[0] != "")
        {
            // Name - Base Level - Class Level - Map - X Coord - Y Coord
            bot_name_map_coords.text = bot_status[0] + " | " + bot_status[1] + "/" + bot_status[2] + " | " + bot_status[14] + " | " + bot_status[15] + "-" + bot_status[16];
            // HP
            float tempBotPer = ((float.Parse(bot_status[7]) / (float.Parse(bot_status[8]))));
            bot_hp_text.text = bot_status[7] + "/" + bot_status[8] + " - " + ((int)(tempBotPer * 100)).ToString() + "%";
            bot_hp_bar.GetComponent<Slider>().value = tempBotPer;
            // SP
            tempBotPer = ((float.Parse(bot_status[9]) / float.Parse(bot_status[10])));
            bot_sp_text.text = bot_status[9] + "/" + bot_status[10] + " - " + ((int)(tempBotPer * 100)).ToString() + "%";
            bot_sp_bar.GetComponent<Slider>().value = tempBotPer;
            // XP Base
            tempBotPer = ((float.Parse(bot_status[3]) / float.Parse(bot_status[4])));
            bot_bxp_text.text = bot_status[3] + "/" + bot_status[4] + " - " + ((int)(tempBotPer * 100)).ToString() + "%";
            bot_bxp_bar.GetComponent<Slider>().value = tempBotPer;
            // XP Class
            tempBotPer = ((float.Parse(bot_status[5]) / float.Parse(bot_status[6])));
            bot_cxp_text.text = bot_status[5] + "/" + bot_status[6] + " - " + ((int)(tempBotPer * 100)).ToString() + "%";
            bot_cxp_bar.GetComponent<Slider>().value = tempBotPer;
            // Peso
            tempBotPer = ((float.Parse(bot_status[11]) / float.Parse(bot_status[12])));
            bot_weight.text = "Peso\n" + bot_status[11] + "/" + bot_status[12] + " - " + ((int)(tempBotPer * 100)).ToString() + "%";
            // Zeny
            bot_zeny.text = "Zeny\n" + bot_status[13];
        }
    }

    IEnumerator GetInventario()
    {
        Camera.main.GetComponent<RemoteUpdates>().bot_real_name = bot_status[0];
        string lista_inventario = "";
        WWWForm form = new WWWForm();
        form.AddField("req_type", "extract_inv");
        form.AddField("name", transform.name);

        UnityWebRequest www = UnityWebRequest.Post(host_address + "/remoteUpdatesPhp/main.php", form);
        yield return www.SendWebRequest();

        if (www.isNetworkError || www.isHttpError)
        {
            Debug.Log(www.error);
        }
        else
        {
            lista_inventario = www.downloadHandler.text;
            string[] split_inventario = lista_inventario.Split('<');
            string[] usb_arm = split_inventario[1].Split('/');
            string[] etc_arm = split_inventario[2].Split('/');
            string[] eqp_arm = split_inventario[0].Split('/');
            string[] usb_inv = split_inventario[3].Split('/');
            string[] etc_inv = split_inventario[4].Split('/');
            string[] eqp_inv = split_inventario[5].Split('/');
            string[] eqpc_inv = split_inventario[6].Split('/');
            for ( int x = 0; x < usb_inv.Length; x++ )
            {
                if (usb_inv[x] != "")
                {
                    GameObject tempItem = Instantiate(usableItem_prefab) as GameObject;
                    string[] tempItemName = usb_inv[x].Split(',');
                    tempItem.name = tempItemName[0];
                    tempItem.transform.GetChild(0).GetComponent<Image>().sprite = usb_image;
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name;
                    tempItem.transform.SetParent(inventario_h);
                }
            }
            for ( int x = 0; x < etc_inv.Length; x++ )
            {
                if (etc_inv[x] != "")
                {
                    GameObject tempItem = Instantiate(item_prefab) as GameObject;
                    tempItem.name = etc_inv[x].Replace(",", " - ");
                    if (etc_inv[x].Contains("Carta "))
                    {
                        tempItem.transform.GetChild(0).GetComponent<Image>().sprite = card_image;

                    }
                    else
                    {
                        tempItem.transform.GetChild(0).GetComponent<Image>().sprite = etc_image;
                    }
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name;
                    tempItem.transform.SetParent(inventario_h);
                }
            }
            for (int x = 0; x < eqp_inv.Length; x++)
            {
                if (eqp_inv[x] != "")
                {
                    GameObject tempItem = Instantiate(item_prefab) as GameObject;
                    tempItem.name = eqp_inv[x];
                    tempItem.transform.GetChild(0).GetComponent<Image>().sprite = eqp_image;
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name;
                    tempItem.transform.SetParent(inventario_h);
                }
            }
            for (int x = 0; x < eqpc_inv.Length; x++)
            {
                if (eqpc_inv[x] != "")
                {
                    GameObject tempItem = Instantiate(item_prefab) as GameObject;
                    tempItem.name = eqpc_inv[x];
                    tempItem.transform.GetChild(0).GetComponent<Image>().sprite = eqp_image;
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name + " - EQP";
                    tempItem.transform.SetParent(inventario_h);
                }
            }
            for (int x = 0; x < usb_arm.Length; x++)
            {
                if (usb_arm[x] != "")
                {
                    GameObject tempItem = Instantiate(item_prefab) as GameObject;
                    tempItem.name = usb_arm[x].Replace(",", " - ");
                    tempItem.transform.GetChild(0).GetComponent<Image>().sprite = usb_image;
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name;
                    tempItem.transform.SetParent(armazem_h);
                }
            }
            for (int x = 0; x < etc_arm.Length; x++)
            {
                if (etc_arm[x] != "")
                {
                    GameObject tempItem = Instantiate(item_prefab) as GameObject;
                    tempItem.name = etc_arm[x].Replace(",", " - ");
                    if (etc_arm[x].Contains("Carta "))
                    {
                        tempItem.transform.GetChild(0).GetComponent<Image>().sprite = card_image;

                    }
                    else
                    {
                        tempItem.transform.GetChild(0).GetComponent<Image>().sprite = etc_image;
                    }
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name;
                    tempItem.transform.SetParent(armazem_h);
                }
            }
            for (int x = 0; x < eqp_arm.Length; x++)
            {
                if (eqp_arm[x] != "")
                {
                    GameObject tempItem = Instantiate(item_prefab) as GameObject;
                    tempItem.name = eqp_arm[x];
                    tempItem.transform.GetChild(0).GetComponent<Image>().sprite = eqp_image;
                    tempItem.GetComponentInChildren<Text>().text = tempItem.name;
                    tempItem.transform.SetParent(armazem_h);
                }
            }
        }
    }

    public void AbrirConsole()
    {
        Camera.main.GetComponent<RemoteUpdates>().ContinueConsole(transform.name);
        Camera.main.GetComponent<RemoteUpdates>().currentScreen = "Console";
    }
}
